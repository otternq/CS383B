"""
Calculates the overall sentiment using the data extracted form the database.
The algorithm assign an overall score to each message.
The overall score of each message is calculatedas follow:
    score = relecance * sentiment / elapsedTime

@author Santiago Pina <pina3608@vandals.uidaho.edu>


"""


import datetime
from relevance import Relevance
from sentiment import Sentiment
from socialDate import SocialDate
import pytz
import math

class Algorithm3:

    @staticmethod
    def getAlgorithmNumber():
        return 3

    @staticmethod
    def getResult(messages):
        n = 0
        sum = 0
        maxRelevance = 0
        minElapsedTime = datetime.timedelta.max
        maxElapsedTime = datetime.timedelta.min
        actualDate = datetime.datetime.utcnow()
        actualDate = actualDate.replace(tzinfo=pytz.utc)

        for message in messages:
            publishedDate = SocialDate.getPublishedDate(message)
            elapsedTime = actualDate - publishedDate
            if elapsedTime < minElapsedTime:
                minElapsedTime = elapsedTime
            if elapsedTime > maxElapsedTime:
                maxElapsedTime = elapsedTime

        messages.rewind()

        for message in messages:
            n += 1
            relevance = Relevance.getRelevance(message)

            if relevance > maxRelevance:
                maxRelevance = relevance

            sentiment = Sentiment.getSentiment(message)
            publishedDate = SocialDate.getPublishedDate(message)
            elapsedTime = actualDate - publishedDate

            normalizedTime = (elapsedTime.total_seconds() - minElapsedTime.total_seconds()) / (maxElapsedTime.total_seconds() - minElapsedTime.total_seconds())
            normalizedRelevance = float(relevance)/maxRelevance
            sum += sentiment * normalizedRelevance / (1+normalizedTime)

        result = sum / n
        print result
        return result
