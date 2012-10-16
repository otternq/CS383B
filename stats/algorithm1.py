"""
Calculates the overall sentiment using the data extracted form the database.
The algorithm assign an overall score to each message.
The overall score of each message is calculatedas follow:
    score = relecance * sentiment / elapsedTime

@author Santiago Pina <pina3608@vandals.uidaho.edu>


"""


import datetime

class Algorithm1 (Algorithm):

    @staticmethod
    def getAlgorithmNumber():
        return 1

    @staticmethod
    def getResult(messages):
        sum = 0
        for message in messages.find():
            relevance = Relevance.getRelevance(message)
            sentiment = Sentiment.getSentiment(message)
            publishedDate = SocialData.getPublishedDate(message)
            actualDate = datetime.datetime.now()
            elapsedTime = actualDate - publishedDate
            sum += relevance * sentiment / elapsedTime.total_seconds()
        return sum
