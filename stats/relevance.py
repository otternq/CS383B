

class Relevance:

    def __getGooglePlusPlusoners(self, message):
        return float(message["data"]["object"]["plusoners"]["totalItems"])

    def __getGooglePlusReplies(self, message):
        return float(message["data"]["object"]["replies"]["totalItems"])

    def __getRedditComments(self, message):
        return float(message["data"]["data"]["num_comments"])

    def __getRedditUps(self, message):
        return float(message["data"]["data"]["ups"])

    def __getFacebookLikes(self, message):
        return float(message["data"]["likes"]["count"])


    def googlePlusRelevance(self, message):
        return __getGooglePlusPlusoners(message) + __getGooglePlusReplies(message)

    def twitterRelevance(self,message):
        return float(message["data"]["metadata"]["recent_retweets"])
    
    def redditRelevance(self, message):
        return __getRedditComments(message) + __getRedditUps(message)

    def facebookRelevance(slef, message):
        return __getFacebookLikes(message)


    

