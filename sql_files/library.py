import random
import datetime

start_date = datetime.date(2000, 1, 1)
end_date = datetime.date(2022, 1, 1)

time_between_dates = end_date - start_date
days_between_dates = time_between_dates.days
random_number_of_days = random.randrange(days_between_dates)

csv = open('books.csv', 'r')
books = open('book.sql', 'w')
authors = open('authors.sql', 'w')
authorship = open('authorship.sql', 'w')
bookinstance = open('bookinstance.sql', 'w')
member = open('member.sql', 'w')
rating = open('rating.sql', 'w')
borrowing = open('borrowing.sql', 'w')

genres = ['Action and Adventure', 'Comic Book', 'Detective and Mystery', 'Fantasy', 'Historical Fiction', 'Horror', 'Literary Fiction', 'Romance', 'Science Fiction', 'Short Stories', 'Thrillers', 'Biographies', 'Cookbooks', 'History']
books.write("set transaction isolation level serializable;\n")
authors.write("set transaction isolation level serializable;\n")
authorship.write("set transaction isolation level serializable;\n")
bookinstance.write("set transaction isolation level serializable;\n")
member.write("set transaction isolation level serializable;\n")
rating.write("set transaction isolation level serializable;\n")
borrowing.write("set transaction isolation level serializable;\n")

author_id_dict = {}
author_id_index = 1
bookinstance_id_index = 1

next(csv)
for line in csv:
    split_line = line.replace("'", "").replace('"', "").split(',')
    books.write("INSERT INTO BOOK VALUES (" + split_line[0] + ",'" + split_line[1] + "','" + split_line[4] + "'," + split_line[5] + ",'" + random.choice(genres) + "');\n")
    if not split_line[2] in author_id_dict:
        author_id_dict[split_line[2]] = author_id_index
        author_id_index += 1
    authorship.write("INSERT INTO AUTHORSHIP VALUES (" + str(author_id_dict[split_line[2]]) + "," + split_line[0] + ");\n")
    for i in range(random.randint(1, 11)):
        bookinstance.write("INSERT INTO BOOKINSTANCE VALUES (" + str(bookinstance_id_index) + "," + split_line[0] + "," + str(random.randint(1, 5)) + ");\n")
        if random.choice([True, False]):
            random_number_of_days = random.randrange(days_between_dates)
            random_date = start_date + datetime.timedelta(days=random_number_of_days)
            if random.choice([True, False]):
                borrowing.write("INSERT INTO BORROWING VALUES ( DATE '" + str(random_date) + "'," + "," + str(random.randint(1, 10000)) + "," + str(bookinstance_id_index) + ");\n")
            else:
                time_between_dates2 = end_date - random_date
                days_between_dates2 = time_between_dates2.days
                random_number_of_days2 = random.randrange(days_between_dates2)
                return_date = random_date + datetime.timedelta(days=random_number_of_days2)
                borrowing.write("INSERT INTO BORROWING VALUES ( DATE '" + str(random_date) + "',DATE '" + str(return_date) + "'," + str(random.randint(1, 10000)) + "," + str(bookinstance_id_index) + ");\n")
        bookinstance_id_index += 1
    for i in range(random.randint(1, 11)):
        random_date = start_date + datetime.timedelta(days=random_number_of_days)
        rating.write("INSERT INTO RATING VALUES (" + str(random.randint(0, 9)) + ",DATE '" + str(random_date) + "'," + str(random.randint(1, 10000)) + "," + split_line[0] + ");\n")

for key in author_id_dict:
    authors.write("INSERT INTO AUTHOR VALUES (" + str(author_id_dict[key])+ ",'" + key + "');\n")

books.write("commit;")
authors.write("commit;")
authorship.write("commit;")
bookinstance.write("commit;")
member.write("commit;")
rating.write("commit;")
borrowing.write("commit;")

csv.close()
books.close()
authors.close()
authorship.close()
bookinstance.close()
member.close()
rating.close()
borrowing.close()
