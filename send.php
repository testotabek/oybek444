<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получаем данные из формы и защищаем от вредоносных вводов
    $name = htmlspecialchars(string: trim(string: $_POST['contact_form_name']));
    $email = htmlspecialchars(string: trim(string: $_POST['contact_form_email']));
    $subject = htmlspecialchars(string: trim(string: $_POST['contact_form_subject']));
    $message = htmlspecialchars(string: trim(string: $_POST['message']));

    // Проверяем, что все поля заполнены
    if (!empty($name) && !empty($email) && !empty($subject) && !empty($message)) {
        // Проверяем корректность email
        if (filter_var(value: $email, filter: FILTER_VALIDATE_EMAIL)) {
            // Настраиваем параметры письма
            $to = "sbumiptk94@gmail.com"; // Замените на ваш email
            $email_subject = "Новое сообщение от $name: $subject";
            $email_body = "Вы получили новое сообщение от $name.\n\n".
                          "Email: $email\n\n".
                          "Сообщение:\n$message";
            $headers = "From: $email\r\n";
            $headers .= "Reply-To: $email\r\n";

            // Отправляем письмо
            if (mail(to: $to, subject: $email_subject, message: $email_body, additional_headers: $headers)) {
                // Перенаправляем на страницу благодарности
                header(header: "Location: thank_you.html");
                exit();
            } else {
                echo "К сожалению, произошла ошибка при отправке сообщения.";
            }
        } else {
            echo "Пожалуйста, введите корректный адрес электронной почты.";
        }
    } else {
        echo "Пожалуйста, заполните все поля формы.";
    }
} else {
    // Если скрипт открыт напрямую, перенаправляем на страницу с формой
    header(header: "Location: contact.html");
    exit();
}
?>


