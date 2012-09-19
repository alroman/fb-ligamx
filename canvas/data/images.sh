#!/bin/bash

GET_URL="http://msn.foxsports.com/fe/fsi/img/futbol/teamLogo/statsInc/headers/"

while read line
do
    wget "$GET_URL$line.png"
    
done < images.txt

