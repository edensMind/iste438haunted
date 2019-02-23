from selenium import webdriver
from selenium.webdriver.common.keys import Keys
import os
from urllib.request import *
import sys
import csv
import requests
import re

#downlad images here
download_path = "images/"

#Selenium Driver
driver = webdriver.Chrome("C:\\_cuts\\Selenium\\chromedriver.exe")

#holds csv rows in a list
csv_list = []

#open csv 
with open('haunted_places.csv', newline='', encoding='utf-8') as f:
    reader = csv.reader(f)
    # add each row as its read into rows list
    for row in reader:
        csv_list.append(row)

#get rid of header row
csv_list.pop(0)

#This is the header row and list indexes
# ['city', 'country', 'description', 'location', 'state', 'state_abbrev', 'longitude', 'latitude', 'city_longitude', 'city_latitude']
#   0       1          2	          3           4        5               6            7           8                 9 

# index number matches line # in csv
index = 2

# for each for in csv
for row in csv_list:
	#if row[5] != "NY" or row[5] == "PA":
	if 1 == 1:

		#creates search term from City + State + Location
		term = row[0] + " " + row[4] + " " + row[3]

		#craete bing image search from term
		url = "https://www.bing.com/images/search?q="+term+"+&FORM=HDRSC2"
		
		#Tell Selenium to go to the URL
		driver.get(url)

		#Selenium headers
		headers = {}
		headers['User-Agent'] = "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36"

		# try to find image elements - if none go to next
		try:
			#get images by div containers class="img_cont"
			images = driver.find_elements_by_class_name("img_cont");

			#get the innerHTML of the FIRST image result
			element = images[0].get_attribute('innerHTML')

			#deserialize the unique image code
			e2 = element.split("id=OIP.")
			e3 = e2[-1].split("&amp;")

			#insert the image code into image URL
			image_url = "https://tse2.mm.bing.net/th?id=OIP."+e3[0]+"&amp;w=230&amp;h=170&amp;rs=1&amp;pcl=dddddd&amp;o=5&amp;pid=1.1"

			#try to download the file
			try:
				#save it as a .jpg
				img_type = "jpg"

				#request the image url
				req = Request(image_url, headers=headers)
				raw_img = urlopen(req).read()

				#save the downloaded image to path (filename is index nubmer for easy association)
				f = open(download_path+str(index)+"."+img_type, "wb")
				f.write(raw_img)
				f.close
			except Exception as e:
				print ("Download failed: {}".format(index))

		except Exception as e:
			print ("Lookup failed: {}".format(index))

	#increment index number for next row
	index += 1

#close Selenium
driver.quit()

