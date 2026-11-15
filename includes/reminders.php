<?php
/**
 * AUTOMATIC DEADLINE REMINDER (1 day before the deadline)
 *
 * For every Active deadline whose date is TOMORROW, notify (in-app + email)
 * only the active faculty who have NOT yet submitted that document type
 * during the deadline's month. Each deadline is reminded only once.
 *
 * Runs cheaply on page loads (HR, Admin, Faculty) - a "poor man's cron".
 * No setting or button is needed any more; it is fully automatic.
 *
 * Returns the number of deadlines that were processed.
 */
function process_due_reminders($conn)
{
    $due = mysqli_query($conn, "
        SELECT sd.*, dc.category_name
        FROM submission_deadlines sd
        JOIN document_categories dc ON dc.category_id = sd.category_id
        WHERE sd.status = 'Active'
          AND sd.deadline_date = DATE_ADD(CURDATE(), INTERVAL 1 DAY)
          AND (sd.last_reminder_sent IS NULL OR DATE(sd.last_reminder_sent) < CURDATE())
    ");

    $processed = 0;
    if (!$due) { return 0; }

    while ($deadline = mysqli_fetch_assoc($due)) {
        // mark first, so two people loading pages at once do not double-send
        $id = (int)$deadline['deadline_id'];
        mysqli_query($conn, "UPDATE submission_deadlines SET last_reminder_sent = NOW() WHERE deadline_id = '$id'");
        send_deadline_reminder($conn, $deadline);
        $processed++;
    }

    return $processed;
}

/**
 * Sends the reminder for one deadline to everyone who has not submitted
 * that document type in the deadline's month. Also used by the manual
 * "Send Now" endpoint (send_reminder.php).
 */
function send_deadline_reminder($conn, $deadline)
{
    $category_id = (int)$deadline['category_id'];
    $deadline_id = (int)$deadline['deadline_id'];
    $monthStart  = date('Y-m-01 00:00:00', strtotime($deadline['deadline_date']));
    $monthEnd    = date('Y-m-t 23:59:59', strtotime($deadline['deadline_date']));

    $notSubmitted = mysqli_query($conn, "
        SELECT u.user_id, u.first_name, u.last_name, u.email
        FROM users u
        WHERE u.role = 'faculty' AND u.status = 'Active'
          AND NOT EXISTS (
              SELECT 1 FROM documents d
              WHERE d.user_id = u.user_id
                AND d.category_id = '$category_id'
                AND d.submitted_at BETWEEN '$monthStart' AND '$monthEnd'
          )
    ");

    $recipients = [];
    $userIds = [];

    while ($notSubmitted && ($u = mysqli_fetch_assoc($notSubmitted))) {
        $recipients[] = ['email' => $u['email'], 'name' => $u['first_name'].' '.$u['last_name']];
        $userIds[] = $u['user_id'];
    }

    $niceDate = date("F j, Y", strtotime($deadline['deadline_date']));
    $niceTime = date("g:i A", strtotime($deadline['deadline_time']));
    $catName  = $deadline['category_name'];

    $notifMessage = mysqli_real_escape_string(
        $conn,
        "Reminder: the deadline for \"$catName\" is tomorrow ($niceDate, $niceTime) and you have not submitted yet."
    );

    if (!empty($userIds)) {
        foreach ($userIds as $uid) {
            mysqli_query($conn, "
            INSERT INTO notifications (user_id, message, type)
            VALUES ('$uid', '$notifMessage', 'deadline_reminder')
            ");
        }

        $emailBody = "
            <p>Hello,</p>
            <p>This is a reminder that the deadline is <strong>tomorrow</strong> and you have <strong>not yet submitted</strong> your:</p>
            <p><strong>Document:</strong> {$catName}<br>
               <strong>Deadline:</strong> {$niceDate}, {$niceTime}</p>
            <p>Please log in to the ISAT U HR Document Management System to submit as soon as possible.</p>
            <p>— ISAT U HR Office</p>
        ";

        send_bulk_notification_email(
            $conn,
            $recipients,
            "Reminder: $catName is due tomorrow",
            $emailBody
        );
    }

    mysqli_query($conn, "
        UPDATE submission_deadlines
        SET last_reminder_sent = NOW()
        WHERE deadline_id = '$deadline_id'
    ");

    return count($userIds);
}

/* Old names kept so older pages keep working */
function process_due_weekly_reminders($conn) { return process_due_reminders($conn); }
function send_weekly_reminder_for_deadline($conn, $deadline) { return send_deadline_reminder($conn, $deadline); }