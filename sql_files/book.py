import random

csv = open('books.csv', 'r')
books = open('book.sql', 'w')
authors = open('authors.sql', 'w')
authorship = open('authorship.sql', 'w')

genres = ['Action and Adventure', 'Comic Book', 'Detective and Mystery', 'Fantasy', 'Historical Fiction', 'Horror', 'Literary Fiction', 'Romance', 'Science Fiction', 'Short Stories', 'Thrillers', 'Biographies', 'Cookbooks', 'History']
books.write("set transaction isolation level serializable;\n")
authors.write("set transaction isolation level serializable;\n")
authorship.write("set transaction isolation level serializable;\n")

author_id_dict = {}
author_id_index = 1

next(csv)
for line in csv:
    split_line = line.replace("'", "").replace('"', "").split(',')
    books.write("INSERT INTO BOOK VALUES (" + split_line[0] + ",'" + split_line[1] + "','" + split_line[4] + "'," + split_line[5] + ",'" + random.choice(genres) + "');\n")
    if not split_line[2] in author_id_dict:
        author_id_dict[split_line[2]] = author_id_index
        author_id_index += 1
    authors.write("INSERT INTO AUTHOR VALUES (" + str(author_id_dict[split_line[2]])+ ",'" + split_line[2] + "');\n")
    authorship.write("INSERT INTO AUTHORSHIP VALUES (" + str(author_id_dict[split_line[2]]) + "," + split_line[0] + ");\n")

books.write("commit;")
authors.write("commit;")
authorship.write("commit;")

csv.close()
books.close()
authors.close()
authorship.close()
