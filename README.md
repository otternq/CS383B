CS383B
=======

Social Stock attempts to analyze social messages from Google+, Facebook, Reddit, and Twitter

Scheduling (cron)
-------
Here is the crontab settings currently being used

```
0 0 * * * cd /home/otternq/stock/getSocialData/deamons/; php testService.php >> cronService.log
5 0 * * * python /home/otternq/stock/stats/daemon.py
```

Warning
-------
This system is part of a class project and should not be used to make any decision involving the Stock Market.