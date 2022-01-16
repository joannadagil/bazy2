import random

csv = open('random_names_fossbytes.csv', 'r')
users = open('users_without_number.sql', 'w')
i = 1
for line in csv:
    users.write("INSERT INTO MEMBER VALUES ("+"'" + line[:-1] + "');\n")
    i += 1

csv.close()
users.close()
