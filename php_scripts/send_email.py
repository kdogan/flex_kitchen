#!/usr/bin/python3

import smtplib
from email.mime.multipart import MIMEMultipart
from email.mime.text import MIMEText
import sys
import json


def send_email(sender, receiver, subject, content):
    try:
        msg = MIMEMultipart('alternative')

        msg['Subject'] = subject
        msg['From'] = sender
        msg['To'] = receiver
        html_body = MIMEText(content, 'html')
        msg.attach(html_body)

        try:
            server = smtplib.SMTP('smarthost.flexlog.site',25)
            server.sendmail(sender,receiver,msg.as_string())
            server.quit()
            return True
        except smtplib.SMTPException as ex:
            print(ex)
            return False
    except smtplib.SMTPException as err:
        return err


if __name__ == "__main__":
    json_file = sys.argv[1]
    contentAsJson = {}
    with open(json_file) as f:
        contentAsJson = json.load(f)
        for k,v in contentAsJson.items():
            receiver = k
            subject = ""
            content = ""
            for k2,v2 in v.items():
                if k2 == "subject":
                    subject = v2
                if k2 == "content":
                    content = v2
            send_email("drinksmanager@flexlog.site", "kamuran.dogan@flexlog.de", subject, content)
