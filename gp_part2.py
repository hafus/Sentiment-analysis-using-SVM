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
##read dataset and 
tweets = pd.read_csv("Tweets.csv")
file = open("stopwords.txt")
stop_words = set(stopwords.words('english')).union(set(file.read().split("\n")))
wordnet_lemmatizer = WordNetLemmatizer()

#normalizing
def normalizer(tweet):
    letters = re.sub("[^a-zA-Z]"," ",tweet)
    lower_letters = letters.lower()
    #Convert www.* or https?://* to URL
    tweet = re.sub('((www\.[^\s]+)|(https?://[^\s]+))','URL',lower_letters)
    #Convert @username to AT_USER
    tweet = re.sub('@[^\s]+','AT_USER',tweet)
    tokens = nltk.word_tokenize(tweet)    
    lower_case = [l.lower() for l in tokens]
    filtered_tweet = list(filter(lambda l:l not in stop_words, lower_case))
    lemmas = [wordnet_lemmatizer.lemmatize(t) for t in filtered_tweet]
    return lemmas

tweets['normalized_tweet'] = tweets.text.apply(normalizer)



def ngrams(input_list):
    bigrams = [' '.join(t) for t in list(zip(input_list, input_list[1:]))]
    trigrams = [' '.join(t) for t in list(zip(input_list, input_list[1:], input_list[2:]))]
    return bigrams+trigrams

tweets['grams'] = tweets.normalized_tweet.apply(ngrams)


def count_words(input):
    counter = collections.Counter()
    for row in input:
        for word in row:
            counter[word] += 1
            
        
    return counter


count_vectorizer = CountVectorizer(ngram_range=(1, 2))

vectorized_data = count_vectorizer.fit_transform(tweets.text)
indexed_data = hstack((np.array(range(0, vectorized_data.shape[0]))[ : , None], vectorized_data))

def sentiment2target(sentiment):
    return {
        "negative" : -1,
        "neutral" : 0,
        "positive" : 1
    }[sentiment]

targets = tweets.airline_sentiment.apply(sentiment2target)


data_train, data_test, targets_train, targets_test = train_test_split(indexed_data, targets, test_size=0.4, random_state=0)
data_train_index = data_train[:,0]
data_train = data_train[:, 1:]
data_test_index = data_test[:,0]
data_test = data_test[:, 1:]

try:
    clf = joblib.load('gp.joblib') 
except (KeyError, FileNotFoundError) as e:
    clf = False
    #print(e.args)

if not clf:
    clf = OneVsRestClassifier(svm.SVC(gamma=0.01, C=100., probability=True, class_weight='balanced', kernel="linear"))
    clf_output = clf.fit(data_train, targets_train)
    joblib.dump(clf, 'gp.joblib')

#print("accuracy of linear kernel is: ")
model_accuracy = clf.score(data_test, targets_test)
#print(model_accuracy)

liveTweets = pd.read_csv("LiveTweets.csv", encoding="utf-8")
sent = count_vectorizer.transform(liveTweets.tweet_text)
liveTweets['sentiment'] = clf.predict(sent)
liveTweets_proba = clf.predict_proba(sent)
liveTweets['negative'], liveTweets['nutral'], liveTweets['postive'] = liveTweets_proba[:,[0]], liveTweets_proba[:,[1]], liveTweets_proba[:,[2]],  
liveTweets[['tweet_text','sentiment','negative', 'nutral', 'postive']].head(20)

#insert statistical data to database
liveTweets['normalized_tweet'] = liveTweets.tweet_text.apply(normalizer)
liveTweets['grams'] = liveTweets.normalized_tweet.apply(ngrams)
liveTweets[['tweet_text','normalized_tweet', 'grams']].head()
#print("predect sentimental values for new tweets.")

cloud_image = "img/circle_mask.png"
mask1 = np.array(Image.open(cloud_image))
text = " ".join(tw for tw in liveTweets["tweet_text"])
wordcloud = WordCloud(max_font_size=50, max_words=1000, stopwords=stop_words, background_color="white", mask=mask1, colormap='brg_r').generate(text)
wordcloud.to_file("img/first_review.png")
#print("finsh word cloud.")

statis = liveTweets.groupby(['sentiment']).size()
no_positive = statis[1] if 1 in statis else 0
no_negative = statis[-1] if -1 in statis else 0
no_nutreal = statis[0] if 0 in statis else 0
no_tweets = liveTweets["tweet_id"].count()
db_conn.execute("DELETE FROM `tweet`;")
conn.commit()
db_conn.execute("DELETE FROM `analysisinfo`;")
conn.commit()
sql_query = 'INSERT INTO `analysisinfo` (`id`, `no_tweets`, `No_airlines`, `no_positive_tweets`, `no_nutreal_tweets`, `no_Negative_tweets`, `model_accuracy`) VALUES(%s,%s,%s,%s,%s,%s,%s);'
sql_data = (1, int(no_tweets), len(sys.argv[1:]), float(no_positive), float(no_nutreal), float(no_negative), float(model_accuracy))
try:
    db_conn.execute(sql_query, sql_data)
except pymysql.IntegrityError as e:
	e = e
    #print("Tweet doesn't inserted to Database.",e.args)
conn.commit()

sql_query = "INSERT INTO `tweet` VALUES(%s, %s, %s, %s, %s, %s, %s, %s);"
for live_tweet in liveTweets.itertuples():
    sql_data = (live_tweet.tweet_id, live_tweet.airline_name, live_tweet.tweet_text, float(live_tweet.postive), float(live_tweet.nutral), float(live_tweet.negative), 1, int(live_tweet.sentiment))
    try:
        db_conn.execute(sql_query, sql_data)
    except pymysql.IntegrityError as e:
        e = e
        #print("Tweet doesn't inserted to Database.",e.args)
    conn.commit()

db_conn.execute("DELETE FROM `wordinfo`;")
conn.commit()
sql_query = 'INSERT INTO `wordinfo` (`id`, `Word`, `No_Repetition`) VALUES(%s,%s,%s);'
count = 1
bag_of_words=()
for data in liveTweets[['grams']].apply(count_words)['grams'].most_common(30):
    sql_data = (count, data[0], data[1])
    count +=1
    try:
        db_conn.execute(sql_query, sql_data)
    except pymysql.IntegrityError as e:
        e = e
		#print("Tweet doesn't inserted to Database.",e.args)
conn.commit()
print(' done')