"""
Calculates the sentiment of the message for Facebook, Google Plus, Twitter and Reddit.

@author Santiago Pina <pina3608@vandals.uidaho.edu>


"""

class Sentiment:

    @staticmethod
    def getSentiment(message):
        try:
            return float(message["sentiment"]["response"]["docSentiment"]["score"])
        except NameError:
            return 0;
