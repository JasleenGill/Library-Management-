#!/usr/local/bin/python3.7

__author__ = "Humberto Luiz Rovina"
__email__ = "humbertorovina@gmail.com"

import cgi, os
import cgitb
from collections import defaultdict

cgitb.enable()

import mysql.connector

print("Content-Type:text/html \n\n")
groupList = []
group = []
users = []
dates = []
destinies = []

destinyGroups = []
finalGroups = []

fileContent = ""

hiddenClass = ""
showClass = "hidden"


class Client(object):
    def __init__(self, name, date, email, destiny, address):
        self.name = name
        self.date = date
        self.destiny = destiny
        self.email = email
        self.address = address


form = cgi.FieldStorage()

if form:
    file = form['file']
    groupSize = int(form.getvalue('groupSize'))
    if file.filename:
        fileLines = file.file.readlines()

        # Creating users
        for line in fileLines:
            userInfo = line.decode("utf-8").split("/")
            if not userInfo[1] in dates:
                dates.append(userInfo[1])
            if not userInfo[3] in destinies:
                destinies.append(userInfo[3])
            users.append(Client(userInfo[0], userInfo[1], userInfo[2], userInfo[3], userInfo[4]))

        # Creating destiny groups
        for destiny in destinies:
            userList = []
            for user in users:
                if user.destiny == destiny:
                    userList.append(user)

            destinyGroups.append(userList)

        # Creating final groups
        for date in dates:
            for commonDestinyUsers in destinyGroups:
                userList = []
                for user in commonDestinyUsers:
                    if user.date == date:
                        userList.append(user)
                if userList:
                    if len(userList) >= groupSize:
                        userSubList = []
                        counter = 1

                        while len(userList) > groupSize:
                            userSubList.append(userList[0])
                            userList.remove(userList[0])
                            counter += 1

                            if counter > groupSize:
                                finalGroups.append(userSubList)
                                userSubList = []
                                counter = 0

                        if userSubList:
                            finalGroups.append(userSubList)

                        if len(userList) > 0:
                            userSubList = []
                            for user in userList:
                                userSubList.append(user)
                            finalGroups.append(userSubList)

                    else:
                        finalGroups.append(userList)

            hiddenClass = "hidden"
            showClass = ""


def readGroups():
    result = ""
    groupCounter = 0

    for group in finalGroups:
        floatStyle = "left"
        groupCounter += 1

        if groupCounter % 2 == 0:
            floatStyle = "right"

        result += "<div class=groups style=\"float: " + floatStyle + "\">"

        result += ("<p><b>Group - " + str(groupCounter) + " - " + group[0].destiny + " - " + group[0].date + "</b></p>")
        emptySpots = groupSize - len(group)
        if emptySpots > 0:
            result += "<p style=\"color:green\"><b>" + " Empty Spot(s): " + str(emptySpots) + "</b></p>"

        else:
            result += "<p style=\"color:red\">" + " Empty Spot(s): " + str(emptySpots) + "</p>"
        result += "<p><b>Participants: </b></p>"
        for client in group:
            result += "<p style=\"text-indent: 1em\">" + client.name + "(" + client.email + ")</p>"
        result += "</div>"

    result += "<p style=\"margin: 0 auto; clear: both;\"></p>"
    result += "<button style=\"margin-left: 45%; clear: both;\" onclick=\"location.href = 'seeGroups.py';\"class=\"button\">Try Again</button>"

    return result


print(
    "<!DOCTYPE html><html lang=\"en\"> <head> <meta charset=\"UTF-8\"><title>XYZ Travel Plan - Login</title><style> body{ margin: 0; padding: 0; border: 0; background: url(\"./img/airplane.jpg\"); background-size: 100%; } h1,h2,h3,h4,p{ font-family: Arial, Helvetica, sans-serif; } h1{ font-size: 50px; } label{ font-family: Arial, Helvetica, sans-serif; font-seix:10px } .button{ margin-left: 30%; margin-top: 5%; font-size: 20px; background-color: white; border: 1px solid darkgreen; } .button:hover{ cursor: pointer; color: white; background-color: #4CAF50;; border: 1px solid darkgreen transition-duration: 0.3s; } #btn-signUp{ margin-left: 2%; } #btn-seeTravelPlans{ border: none; background-color: white; margin-left: 37%; font-size: 10px; } #btn-seeTravelPlans:hover{ color: blue; } .sections{ margin: 0 auto; margin-top: 50px; padding: 20px; background-color: white; border-radius: 10px; } .sections:hover{ box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); }  .submitDiv{ width: 30%; } .groupsDiv{ margin-bottom: 5%; width: 70%; } .hidden{ display: none; } .show{ display: block } .groups{ min-height: 200px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); width: 45%; padding:5px; margin: 10px; border-radius: 5px; border: 1px solid grey; background-color: white; float: left; } </style> </head> <body> <div style=\"width: 100%; height: 100px;padding-top: 50px; background-color: black; margin-top: 0\"> <a style=\"text-decoration: none;\"href=\"./index.php\"><h1 style=\"text-align: center; margin-top: 0; color: white;\">XYZ Travel Plan</h1></a></div> <main> <div class=\"" + hiddenClass + " submitDiv sections\"> <h2>Please, fill the form:</h2>")
print("""
<form method=\"post\" enctype=\"multipart/form-data\">
    <label>Enter the size of each group:</label>
    <input type=\"number\" name=\"groupSize\" required>
    <br><br>
    <label>Import File:</label>
    <input type=\"file\" name=\"file\" accept=\".txt\" required><br>
    <input class=\"button\" type=\"submit\" name=\"submit\" value=\"Generate Groups\">
</form></div>""")

print("""
<div class=\"sections groupsDiv """ + showClass + """ \">
    <h2> Generated groups: </h2>
    """ + str(readGroups()) + """
</div>
""")

print("</main></html>")
