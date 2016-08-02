#!/usr/bin/env python
# -*- coding: iso-8859-1 -*-

import sys
import getopt
import urllib2
import re
import  time

'''
http://www.pilotpub.com/fuel-prices.php
http://www.airnav.com/airport/TNCM

https://flightaware.com/resources/airport/TNCM

schedules file : phpvms_schedules.csv
'''

#-------------------------------------------------------------------------------

icaolist = {}

fuelUrl = "https://flightaware.com/resources/airport/"
fuelRegex = "^.+<td class=\"money\">(\$(?P<price>[0-9.]+)||\?\?\?)</td>.*$"


#-------------------------------------------------------------------------------

def getFulePrices():

    global icaolist
    
    lolead = "";
    jeta = "";
    
    for key in icaolist:
        print "request fuel price for airport : ", key

        try:
            response = urllib2.urlopen(fuelUrl + key)
        except urllib2.HTTPError, e:
            print "airport not available ..."
            icaolist[key] = None, None
            time.sleep(2)
            continue

        html = response.readlines()
        response.close()
        
        pattern = re.compile(fuelRegex)
        matchCount = 0;
        for line in html:

            match = pattern.match(line)
            if match:
            
                #print "match line: ", line
                
                if matchCount == 0:
                    #print "lolead : ", match.group('price')
                    lolead = match.group('price')
                
                if matchCount == 2:
                    #print "jeta : ", match.group('price')
                    jeta = match.group('price')
                    
                matchCount+=1

        #print "price ll:", lolead, " jeta:", jeta
        
        if jeta == "": jeta = None
        if lolead == "": lolead = None
        
        # save jeta and ll price in dictionary
        icaolist[key] = jeta, lolead
        #print icaolist[key]
        lolead = ""
        jeta = ""
        
        time.sleep(2)

    return
        
        
        
    response = urllib2.urlopen(fuelUrl + "TAPA")
    html = response.readlines()
    response.close()
    print "html response len : ", len(html)
    
    pattern = re.compile(fuelRegex)
    for line in html:
        match = pattern.match(line)
        if match:
            print line , match.group('price')
        
        
#-------------------------------------------------------------------------------

def exportPriceList(filename):

    global icaolist
    
    pricefile = open(filename, 'w')
    pricefile.write('ICAO jeta lolead\n')
    
    for key in icaolist:
    
        if icaolist[key][0] == None and icaolist[key][1] == None:
            continue
        
        print "save airport : " + key
        ostr = "" + key + " "
        #print icaolist[key]
        
        if icaolist[key][0] != None:
            ostr += icaolist[key][0]
        else:
            ostr += 'N/A'
            
        ostr += " "
        
        if icaolist[key][1] != None:
            ostr += icaolist[key][1]
        else:
            ostr += 'N/A'
            
        ostr += "\n"
        
        pricefile.write(ostr)
    
    pricefile.close()
    
#-------------------------------------------------------------------------------

def readScheduleFile(scheduleFile):

    global icaolist
    
    try:
        print "reading schedule list : " + scheduleFile
        for line in open(scheduleFile, 'r'):
        
            cols = line.split(',')
            
            # add departure and arrival airport into dictionary
            # must not check dublicate keys
            icaolist[cols[3].replace("\"", "")] = "";
            icaolist[cols[4].replace("\"", "")] = "";
            
    except IOError:
        print "error while reading file : " + scheduleFile
        
    print "-> ", len(icaolist), " airports in the list"  

#-------------------------------------------------------------------------------

def usage():

    print """
fuel_price.py
    -f, --filename the database schedule table csv export"
    -o, --output   output file
"""

#-------------------------------------------------------------------------------

def main(argv):

    scheduleFile = ""
    command = ""
    
    try:                                
        opts, args = getopt.getopt(argv, "hf:o:", ["help", "file="])
    except getopt.GetoptError:
        usage()
        sys.exit(2)
        
    for opt, arg in opts:
        if opt in ("-h", "--help"):
            usage()
            sys.exit()
        elif opt in ("-f", "--file"):
            scheduleFile = arg
        elif opt in ("-o", "--output"):
            outFile = arg

    if scheduleFile == "":
        print "no schedule file set"
        usage()
        sys.exit()

    if outFile == "":
        print "no output file set"
        usage()
        sys.exit()
        
    readScheduleFile(scheduleFile)
    getFulePrices()
    exportPriceList(outFile)
    

#-------------------------------------------------------------------------------

if __name__ == "__main__":
    main(sys.argv[1:])
