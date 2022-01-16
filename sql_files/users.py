import random

csv = open('random_names_fossbytes.csv', 'r')
users = open('users.sql', 'w')
i = 1
for line in csv:
    users.write("INSERT INTO USER VALUES (" + str(i) + ",'" + line[:-1] + "');\n")
    i += 1

csv.close()
users.close()
