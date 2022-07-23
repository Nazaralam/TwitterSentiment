from flask import Flask, request, jsonify
from flask_cors import CORS, cross_origin
from textblob import TextBlob
import tweepy
import sys
import re

app = Flask(__name__)
cors = CORS(app, resources={r"/foo": {"origins": "*"}})
app.config['CORS_HEADERS'] = 'Content-Type'

api_key = "iW7HI1tmoOrd38M4WRFom1TD0"
api_key_secret = "OCLrwIsw7xQi4qHv5dQUHfDirEEJsiofO9wvWPv8PsfviRAFhC"
access_token = "445851588-19wyplWPB6TqlRLrldg0DwVcAK9PKTWNEqy97mrW"
access_token_secret = "iXLeWchW33vQIlMztKG6ozqD8ItG8WsjnhV5Ky0YDfHCY"

@app.route('/api/sentiment/<figure>', methods=['GET'])
@cross_origin(origin='*',headers=['Content-Type','Authorization'])
def sentimentFigure(figure):
    auth_handler = tweepy.OAuthHandler(api_key, api_key_secret)
    auth_handler.set_access_token(access_token, access_token_secret)

    api = tweepy.API(auth_handler)

    searchResult = api.search_tweets(q=figure, lang='en', count=100)
    analyzeResult = []

    #cleaning the tweet
    for tweet in searchResult:
        tweet_properties = {}
        tweet_properties["time"] = tweet.created_at
        tweet_properties["username"] = tweet.user.screen_name
        tweet_properties["tweet"] = tweet.text
        #tweet_properties["Subjectivity"] = analysis.subjectivity
        tweet_clean = ' '.join(re.sub("(@[A-Za-z0-9]+)|([^0-9A-Za-z \t])|(\w+:\/\/\S+)"," ",tweet.text).split())

        #print(tweet_clean)
        analysis = TextBlob(tweet_clean)

            #divided the sentiment by rounding number/number approximately for polarity
        if analysis.sentiment.polarity >= 1:
            tweet_properties["sentiment"] = "++"
        elif analysis.sentiment.polarity >= 0.1 < 1:
            tweet_properties["sentiment"] = "+"
        elif analysis.sentiment.polarity == 0.0:
            tweet_properties["sentiment"] = "0"
        elif analysis.sentiment.polarity <= -0.1 > -1:
            tweet_properties["sentiment"] = "-"
        else:
            tweet_properties["sentiment"] = "--"


            #to analyze subjectivity tweet
        if analysis.sentiment.subjectivity < 0.5:
            tweet_properties["subjectivity"] = "Factual"
        else:
            tweet_properties["subjectivity"] = "Personal Opinion"

        #limit the amount of retweet max. 1 in each tweet
        if tweet.retweet_count > 0:
            if tweet_properties not in analyzeResult:
                analyzeResult.append(tweet_properties)
            else:
                analyzeResult.append(tweet_properties)

    tweet_Positive = [t for t in analyzeResult if t["sentiment"] =="++"]
    tweet_Semipositive = [t for t in analyzeResult if t["sentiment"] =="+"]
    tweet_Neutral = [t for t in analyzeResult if t["sentiment"] =="0"]
    tweet_Seminegative= [t for t in analyzeResult if t["sentiment"] =="-"]
    tweet_Negative= [t for t in analyzeResult if t["sentiment"] =="--"]

    attitudeResult = "Neutral"

    res = len(tweet_Positive)+len(tweet_Semipositive)
    res2 = len(tweet_Negative)+len(tweet_Seminegative)

    if res > res2:
        attitudeResult = "Good!"
    elif res < res2:
        attitudeResult = "Bad!"
    else:
        if tweet_Positive > tweet_Negative:
            attitudeResult = "Good!"
        elif tweet_Positive < tweet_Negative:
            attitudeResult = "Bad!"

    sentiment_result = len(tweet_Positive), len(tweet_Semipositive), len(tweet_Neutral), len(tweet_Seminegative), len(tweet_Negative),

    return jsonify({
        'attitude': attitudeResult,
        'sentiment': sentiment_result,
        'data': analyzeResult
    })

if __name__ == '__main__':
    app.run()
