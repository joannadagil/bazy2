import random
import datetime

csv = open('random_names_fossbytes.csv', 'r')
users = open('users.sql', 'w')


start_date = datetime.date(1940, 1, 1)
end_date = datetime.date(2010, 2, 1)

time_between_dates = end_date - start_date
days_between_dates = time_between_dates.days
random_number_of_days = random.randrange(days_between_dates)
random_date = start_date + datetime.timedelta(days=random_number_of_days)

i = 1
for line in csv:
    random_number_of_days = random.randrange(days_between_dates)
    random_date = start_date + datetime.timedelta(days=random_number_of_days)
    users.write("INSERT INTO MEMBER VALUES (" + str(i) + ",'" + line[:-1] + "',DATE '" +str(random_date)+ "');\n")
    i += 1

csv.close()
users.close()
