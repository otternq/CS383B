"""
Calculates the overall sentiment using the data extracted form the database.
The algorithm assign an overall score to each message.
The overall score of each message is calculatedas follow:
    score = relecance * sentiment / elapsedTime

@author Santiago Pina <pina3608@vandals.uidaho.edu>


"""

import datetime
from Functions.relevance import Relevance
from Functions.sentiment import Sentiment
from Functions.socialDate import SocialDate
import pytz

class Algorithm2:

    @staticmethod
    def getAlgorithmNumber():
        return 2

    @staticmethod
    def getResult(messages):
        n = 0
        sum = 0.0
        maxRelevance = 0
        minElapsedTime = datetime.timedelta.max
        actualDate = datetime.datetime.utcnow()
        actualDate = actualDate.replace(tzinfo=pytz.utc)

        for message in messages:
            publishedDate = SocialDate.getPublishedDate(message)
            elapsedTime = actualDate - publishedDate
            if elapsedTime < minElapsedTime:
                minElapsedTime = elapsedTime

        messages.rewind()

        for message in messages:
            n += 1
            relevance = Relevance.getRelevance(message)

            if relevance > maxRelevance:
                maxRelevance = relevance

            sentiment = Sentiment.getSentiment(message)
            publishedDate = SocialDate.getPublishedDate(message)
            elapsedTime = actualDate - publishedDate
            sum += relevance * sentiment / (1 + elapsedTime.total_seconds() - minElapsedTime.total_seconds())

        result = sum / (maxRelevance * n)
        return result
