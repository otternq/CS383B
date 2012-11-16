import unittest
from database.MongoInterface import MongoInterface
from algorithms.Algorithm1 import Algorithm1
from algorithms.Algorithm2 import Algorithm2
from algorithms.Algorithm3 import Algorithm3

class UnitTest(unittest.TestCase):

    def setUp(self):
        self.db = MongoInterface()
        self.services = ["Twitter", "Google Plus", "Facebook", "Reddit"]

    def test_algorithm1(self):

        for service in self.services:
            messages = self.db.messageByService(service)

            for message in messages:
                self.assertEqual(message["service"], service)

            messages.rewind()

            num = Algorithm1.getAlgorithmNumber()
            res = Algorithm1.getResult(messages)
            self.assertIsInstance(num, int)
            self.assertIsInstance(res, float)


    def test_algorithm2(self):

        for service in self.services:
            messages = self.db.messageByService(service)

            for message in messages:
                self.assertEqual(message["service"], service)

            messages.rewind()

            num = Algorithm2.getAlgorithmNumber()
            res = Algorithm2.getResult(messages)
            self.assertIsInstance(num, int)
            self.assertIsInstance(res, float)



    def test_algorithm3(self):

        for service in self.services:
            messages = self.db.messageByService(service)

            for message in messages:
                self.assertEqual(message["service"], service)

            messages.rewind()

            num = Algorithm3.getAlgorithmNumber()
            res = Algorithm3.getResult(messages)
            self.assertIsInstance(num, int)
            self.assertIsInstance(res, float)
            self.assertGreater(res, -0.5)
            self.assertLess(res, 0.5)


if __name__ == '__main__':
    unittest.main()
