# csvモジュールを使ってCSVファイルから1行ずつ読み込む
import csv
from itertools import islice

import mysql.connector

filename = 'kindergarden_data.csv'

mydb = mysql.connector.connect(
  host="localhost",
  user="root",
  password="",
  database="kindergarden"
)


with open(filename, encoding='utf8', newline='') as f:
    csvreader = csv.reader(f)
    print(type(csvreader))

    next(csvreader)

    for row in csvreader:
        mycursor = mydb.cursor()

        sql = "SELECT * FROM corporate WHERE business_id = %s"
        val = (row[10], ) 
        mycursor.execute(sql, val)
        myresult = mycursor.fetchall()

        if len(myresult) == 0:
          sql = "INSERT INTO corporate (name,name_hiragana,postal_code, address_prefecture, address_district,address_street,address_building, phone_number, business_id) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)"
          val = (row[2], row[1], row[3], row[4], row[5], row[6], row[7], row[8], row[10])

          mycursor.execute(sql, val)
          mydb.commit()

        
        