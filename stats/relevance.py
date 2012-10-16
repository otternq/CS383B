"""
Calculates the relevance of the message for Facebook, Google Plus, Twitter and Reddit.

@author Santiago Pina <pina3608@vandals.uidaho.edu>


"""


class Relevance:

    @staticmethod
    def __getGooglePlusPlusoners(message):
        return float(message["data"]["object"]["plusoners"]["totalItems"]) + 1

    @staticmethod
    def __getGooglePlusReplies(message):
        return float(message["data"]["object"]["replies"]["totalItems"])

    @staticmethod
    def __getRedditComments(message):
        return float(message["data"]["data"]["num_comments"])

    @staticmethod
    def __getRedditUps(message):
        return float(message["data"]["data"]["ups"])

    @staticmethod
    def __getTwitterRetwits(message):
        return float(message["data"]["metadata"]["recent_retweets"]) + 1

    @staticmethod
    def __getFacebookLikes(message):
        try:
            return float(message["data"]["likes"]["count"]) + 1
        except KeyError:
            return 1.0


    @staticmethod
    def googlePlusRelevance(message):
        return Relevance.__getGooglePlusPlusoners(message) + Relevance.__getGooglePlusReplies(message)

    @staticmethod
    def twitterRelevance(message):
        return Relevance.__getTwitterRetwits(message)

    @staticmethod
    def redditRelevance(message):
        return Relevance.__getRedditComments(message) + Relevance.__getRedditUps(message)

    @staticmethod
    def facebookRelevance(message):
        return Relevance.__getFacebookLikes(message)

    @staticmethod
    def getRelevance(message):
        if message['service'] == "GooglePlus":
            return Relevance.googlePlusRelevance(message)

        elif message['service'] == "Facebook":
            return Relevance.facebookRelevance(message)

        elif message['service'] == "Reddit":
            return Relevance.redditRelevance(message)

        elif message['service'] == "Twitter":
            return Relevance.twitterRelevance(message)

