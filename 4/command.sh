#!/bin/bash

##### Top 5 fives
echo "Top 5 IPs:"
awk '{print $1}' sample.log.txt | sort | uniq -c | sort -nr | head -5

##### 404500 error urls
echo -e "\nURLs with 404 Errors:"
awk '$9 == 404 {print $7}' sample.log.txt | sort | uniq

echo -e "\nCleaned Log:"
cat sample.log.txt | tr '\t' ' ' | sed '/^$/d' | sed 's/  */ /g' | grep -E '" (200|301|302|400|403|404|500|502|503) '
