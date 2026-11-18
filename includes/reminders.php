<?php
/**
 * Automatically checks every active, upcoming deadline. Once the deadline is
 * within 24 hours (the day before), it sends ONE reminder to every faculty
 * member who still hasn't submitted that document type. No per-deadline
 * setting is needed. Deadlines posted less than a day ahead are skipped,
 * because faculty were just notified when the deadline was posted.
 *
 * Designed to be called cheaply on every HR page load (a "poor man's cron").
 * For a more reliable production setup, this same logic can instead be
 * triggered by a real scheduled task (e.g. Windows Task Scheduler hitting
 * a URL, or a cron job) — see send_reminder.php for a callable endpoint.
 *
 * Returns the number of deadlines that were processed.
 */
function process_due_weekly_reminders($conn)
{
    $due = mysqli_query($conn, "
        SELECT sd.*, dc.category_name
        FROM submission_deadlines sd
        JOIN document_categories dc ON dc.category_id = sd.category_id
        WHERE sd.status = 'Active'
          AND TIMESTAMP(sd.deadline_date, sd.deadline_time) > NOW()
          AND NOW() >= (TIMESTAMP(sd.deadline_date, sd.deadline_time) - INTERVAL 1 DAY)
          AND sd.created_at < (TIMESTAMP(sd.deadline_date, sd.deadline_time) - INTERVAL 1 DAY)
          AND (sd.last_reminder_sent IS NULL
               OR sd.last_reminder_sent < (TIMESTAMP(sd.deadline_date, sd.deadline_time) - INTERVAL 1 DAY))
    ");

    $processed = 0;

    while ($deadline = mysqli_fetch_assoc($due)) {
        send_weekly_reminder_for_deadline($conn, $deadline);
        $processed++;
    }

    return $processed;
}

/**
 * Sends the reminder for one specific deadline, regardless of timing
 * (called internally by process_due_weekly_reminders()).
 */
function send_weekly_reminder_for_deadline($conn, $deadline)
{
    $category_id = (int)$deadline['category_id'];
    $deadline_id = (int)$deadline['deadline_id'];

    $notSubmitted = mysqli_query($conn, "
        SELECT u.user_id, u.first_name, u.last_name, u.email
        FROM users u
        WHERE u.role = 'faculty' AND u.status = 'Active'
          AND NOT EXISTS (
              SELECT 1 FROM documents d
              WHERE d.user_id = u.user_id
                AND d.category_id = '$category_id'
                AND d.submitted_at >= '{$deadline['created_at']}'
          )
    ");

    $recipients = [];
    $userIds = [];

    while ($u = mysqli_fetch_assoc($notSubmitted)) {
        $recipients[] = ['email' => $u['email'], 'name' => $u['first_name'].' '.$u['last_name']];
        $userIds[] = $u['user_id'];
    }

    $niceDate = date("F j, Y", strtotime($deadline['deadline_date']));
    $niceTime = date("g:i A", strtotime($deadline['deadline_time']));
    $catName = $deadline['category_name'];

    $notifMessage = mysqli_real_escape_string(
        $conn,
        "Reminder: you still haven't submitted \"$catName\". Deadline is $niceDate, $niceTime."
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
            <p>This is a reminder that you have <strong>not yet submitted</strong> your:</p>
            <p><strong>Document:</strong> {$catName}<br>
               <strong>Deadline:</strong> {$niceDate}, {$niceTime}</p>
            <p>Please log in to the ISAT U HR Document Management System to submit as soon as possible.</p>
            <p>— ISAT U HR Office</p>
        ";

        send_bulk_notification_email(
            $conn,
            $recipients,
            "Reminder: $catName submission still pending",
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