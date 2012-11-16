"""
Calculates the published date of the message for Facebook, Google Plus, Twitter and Reddit.

@author Santiago Pina <pina3608@vandals.uidaho.edu>


"""
import dateutil.parser as dateparser
import datetime
import pytz

class SocialDate:

    @staticmethod
    def googlePlusDate(message):
        return dateparser.parse(message["data"]["published"])

    @staticmethod
    def redditDate(message):
        aux = datetime.datetime.fromtimestamp(long(message["data"]["data"]["created_utc"]))
        return aux.replace(tzinfo=pytz.utc)


    @staticmethod
    def facebookDate(message):
        return dateparser.parse(message["data"]["created_time"])

    @staticmethod
    def twitterDate(message):
        return dateparser.parse(message["data"]["created_at"])

    @staticmethod
    def getPublishedDate(message):
        if message['service'] == "Google Plus":
            return SocialDate.googlePlusDate(message)

        elif message['service'] == "Facebook":
            return SocialDate.facebookDate(message)

        elif message['service'] == "Reddit":
            return SocialDate.redditDate(message)

        elif message['service'] == "Twitter":
            return SocialDate.twitterDate(message)

