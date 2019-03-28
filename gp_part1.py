#!"C:\Users\-\AppData\Local\Programs\Python\Python36-32\python"
#print('Content-Type: text/html')
#print()

import cgitb
import sys
import os
#to handel import error when run this script from php
cgitb.enable()
os.environ['APPDATA'] = os.environ['APPDATA'] if 'APDATA' in os.environ else 'C:\\Users\\-\\AppData\\Roaming'

import tweepy
import csv
import pandas as pd
import pymysql
import re , nltk
#from nltk import ngrams
from nltk.stem import WordNetLemmatizer
from nltk.corpus import stopwords
import collections
import sys

import numpy as np
from scipy.sparse import hstack
from sklearn.feature_extraction.text import CountVectorizer

from sklearn.model_selection import train_test_split

from sklearn import svm
from sklearn.multiclass import OneVsRestClassifier

from wordcloud import WordCloud
from PIL import Image
from sklearn.externals import joblib

conn = pymysql.connect(host='127.0.0.1', user = 'pma', password = '', db = 'gp')
db_conn = conn.cursor()
####input your credentials here
consumer_key = 'ENTER YOUR CONSUMER KEY HERE'
consumer_secret = 'ENTER YOUR CONSUMER SECRET KEY HERE'
access_token = 'ENTER YOUR ACCESS TOKEN HERE'
access_token_secret = 'ENTER YOUR SECRET ACESS TOKEN HERE'

auth = tweepy.OAuthHandler(consumer_key, consumer_secret)
auth.set_access_token(access_token, access_token_secret)
api = tweepy.API(auth,wait_on_rate_limit=True)


# Open/Create a file to append data
header = ["tweet_id", "airline_name", "tweet_text", "date", "hashtags", "likes"]
csvFile = open('LiveTweets.csv', 'w', newline='', encoding="utf-8")
#Use csv Writer
csvWriter = csv.writer(csvFile, delimiter=',')
csvWriter.writerow(header)

tag_list = [["Singapore Airlines_SI", "#Singapore_Airlines OR #SingaporeAirlines OR @SingaporeAir"],
            ["Japan Airlines_JA", "#Japan_Airlines OR #JapanAirlines OR @JAL_Official_jp OR @JALFlightInfo_e"],
            ["Emirates Airlines_EM", "#Emirates_Airlines OR #EmiratesAirlines OR @emirates"],
            ["Cathay Pacifi Airlines_CAT", "#Cathay_Pacific OR #CathayPacific OR #Cathay_Pacifi_Airlines OR #CathayPacifiAirlines OR @cathaypacific"],
            ["EVA Airlines_EVA", "#EVA_Air OR #EVAAir OR #EVA_Airlines OR #EVAAirlines OR @EVAAirUS"],
            ["Etihad Airways_ET", "#Etihad_Airways OR #EtihadAirways OR @EtihadAirways OR @EtihadAirwaysAR"],
            ["Lufthansa Airline_LU", "#Lufthansa_Airline OR #LufthansaAirline OR @LufthansaFlyer"],
            ["Oman Airlines_OM", "#Oman_Air OR #OmanAir OR #Oman_Airlines OR #OmanAirlines OR @omanair"],
            ["Saudi Arabian Airlines_SAU", "#Saudi_Arabian_Airlines OR #SaudiArabianAirlines OR #Saudi_Airlines OR #SaudiAirlines OR @Saudi_Airlines"],
            ["Royal Air Maroc_MAR", "#Royal_Air_Maroc OR #Royal_Maroc_Airlines OR #RoyalAirMaroc OR #RoyalMarocAirlines OR @RAM_Maroc"]
           ]
#Filter tweets recevid from twitter
def filter_location(tweet, airline_name):
    
    ksa_reg = ['saudi','SA', 'السعودية', 'riyadh', 'makkah', 'kharj', 'dawasir', 'mecca', 'jeddah', 'taif', 'medina', 'madinah', 'qassim',
              'dammam', 'ahsa', 'batin', 'jubail', 'khobar', 'khafji', 'asir', 'jawf', 'bahah', 'najran', 'jizan', 'hail', 'tabuk',
              '🇸🇦','jeedah', 'dmm', 'saudia', 'sa', 'jed', 'alkharj',
               'الباحة', 'ksa', 'الخرج', 'الشرقية', 'تنومة', 'الخفجي', 'القصيم', 'بريدة', 'الطائف', 'الاحساء', 'الثقبة', 'نجران', 
               'الدمام', 'السعوديه', 'المدينة', 'حايل', 'السعودي', 'عنيزة', 'جازان', 'الجبيل', 'مكة', 'جدة', 'السعود', 'الرياض','الخبر']
    if tweet.geo:
        return True
    elif tweet.place:
        if str(tweet.place).split('\',')[5][15:] == 'SA':
            return True
        elif str(tweet.place).split('\',')[5][15:] == 'KW':
            return True
        elif str(tweet.place).split('\',')[5][15:] == 'AE':
            return True
        elif str(tweet.place).split('\',')[5][15:] == 'QA':
            return True
        elif str(tweet.place).split('\',')[5][15:] == 'BH':
            return True
        elif str(tweet.place).split('\',')[5][15:] == 'OM':
            return True
    elif tweet.user.location:
            if set(ksa_reg).intersection(set([s.lower() for s in re.sub('[^a-zA-Zأ-ي]', ' ', tweet.user.location).split()])):
                return True
            elif set(['kuwait', 'kw', 'الكويت']).intersection(set([s.lower() for s in re.sub('[^a-zA-Zأ-ي]', ' ', tweet.user.location).split()])):
                return True
            elif set(['emirates', 'emiratos', 'ae', 'abudhabi', 'dhabi', 'dubai', 'أبوظبي', 'دبـي', 'uae', 'الامارات']).intersection(set([s.lower() for s in re.sub('[^a-zA-Zأ-ي]', ' ', tweet.user.location).split()])):
                return True
            elif set(['qatar','qa', 'doha', 'قطر']).intersection(set([s.lower() for s in re.sub('[^a-zA-Zأ-ي]', ' ', tweet.user.location).split()])):
                return True
            elif set(['bahrain','bh', 'البحرين']).intersection(set([s.lower() for s in re.sub('[^a-zA-Zأ-ي]', ' ', tweet.user.location).split()])):
                return True
            elif set(['oman','om', 'عمان']).intersection(set([s.lower() for s in re.sub('[^a-zA-Zأ-ي]', ' ', tweet.user.location).split()])):
                return True
    elif airline_name in ['Emirates Airlines_EM', 'Oman Airlines_OM', 'Saudi Arabian Airlines_SAU', 'Etihad Airways_ET']:
            return True
    return False

#read tweets from twitter
for index in list(map(int, sys.argv[1:])):
    for tweet in tweepy.Cursor(api.search,q= tag_list[index][1], 
                               tweet_mode='extended',
                               count=10000,
                               lang="en",
                               geocode="24.488370,45.922187,1200km",
                               since="2006-04-03").items():
        
        hashtags = [h['text'] for h in tweet.entities['hashtags']]
        if filter_location(tweet, tag_list[index][0]):
            csvWriter.writerow([tweet.id_str, tag_list[index][0], tweet.full_text, tweet.created_at,
                            ', '.join(hashtags), tweet.favorite_count])
        sql_query="INSERT INTO `KSA_Dataset` VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s);"
        sql_data = (tweet.id_str, tag_list[index][0], tweet.full_text, tweet.created_at, ', '.join(hashtags), tweet.favorite_count, str(tweet.user.location), str(tweet.geo), str(tweet.place))                                                                                               
        try:
            db_conn.execute(sql_query, sql_data)
        except pymysql.IntegrityError as e:
            e = e
            #print("Tweet doesn't inserted to Database.",e.args)
            
        conn.commit()
csvFile.close()
print(" finsh")
