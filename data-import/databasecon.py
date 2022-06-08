import mysql.connector

mydb = mysql.connector.connect(
  host="localhost",
  user="root",
  password="",
  database="kindergarden"
)

mycursor = mydb.cursor()

sql = "SELECT * FROM facility"

mycursor.execute(sql)


print(mycursor.rowcount, "record inserted.")
