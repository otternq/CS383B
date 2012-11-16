CS383B
=======

Social Stock attempts to analyze social messages from Google+, Facebook, Reddit, and Twitter

Scheduling (cron)
-------
Here is the crontab settings currently being used. Replace `/path/to/repo/` with the directory path to your installation path

```
0 0 * * * cd /path/to/repo/getSocialData/deamons/; php testService.php >> cronService.log
5 0 * * * python /path/to/repo/stats/daemon.py
```

Warning
-------
This system is part of a class project ([CS 383](http://www2.cs.uidaho.edu/~oman/CS383/CS383_F12_syllabus.htm) at The University of Idaho) and should not be used to make any financial decisions, especially those involving the Stock Market.