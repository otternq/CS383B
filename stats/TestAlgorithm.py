import unittest
from database.MongoInterface import MongoInterface
from Algorithms.algorithm1 import Algorithm1
from Algorithms.algorithm2 import Algorithm2
from Algorithms.algorithm3 import Algorithm3

class TestAlgorithm(unittest.TestCase):

    def setUp(self):
        self.db = MongoInterface()
        self.services = ["Twitter", "Google Plus", "Facebook", "Reddit"]

    def test_algorithm1(self):

        for service in self.services:
            messages = self.db.messageByService(service)
            num = Algorithm1.getAlgorithmNumber()
            res = Algorithm1.getResult(messages)
            self.assertIsInstance(num, int)
            self.assertIsInstance(res, float)


    def test_algorithm2(self):

        for service in self.services:
            messages = self.db.messageByService(service)
            num = Algorithm2.getAlgorithmNumber()
            res = Algorithm2.getResult(messages)
            self.assertIsInstance(num, int)
            self.assertIsInstance(res, float)



    def test_algorithm3(self):

        for service in self.services:
            messages = self.db.messageByService(service)
            num = Algorithm3.getAlgorithmNumber()
            res = Algorithm3.getResult(messages)
            self.assertIsInstance(num, int)
            self.assertIsInstance(res, float)
            self.assertGreater(res, -0.5)
            self.assertLess(res, 0.5)


if __name__ == '__main__':
    unittest.main()
