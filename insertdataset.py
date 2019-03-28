#!"C:\Users\-\AppData\Local\Programs\Python\Python36-32\python"
print('Content-Type: text/html')
print()
import cgi, cgitb 
import pandas as pd

form = cgi.FieldStorage()
if(form.getvalue("op") == 'insert'):
    tweet_id = form.getvalue('id')
    tweet_text  = form.getvalue('tweet')
    tweet_class = form.getvalue('class')

    dataset = pd.read_csv("Tweets.csv")
    dat = (tweet_id, tweet_class, 0, "", 0, ' ', "", "", "", 0, tweet_text,"", '' , "", "")    
    newframe = pd.DataFrame([dat], dtype=str, columns=dataset.columns.values)
    new_dataset = dataset.append(newframe)
    new_dataset.to_csv("Tweets.csv",sep = ',', index = False, encoding="utf-8")
 
else:
     tweet_id = form.getvalue('id')
     dataset = pd.read_csv("result1.csv")
     dataset = dataset.set_index("tweet_id")
     dataset = dataset.drop(tweet_id, axis=0)
     dataset.to_csv("result2.csv",sep = ',', index = False, encoding="utf-8")

