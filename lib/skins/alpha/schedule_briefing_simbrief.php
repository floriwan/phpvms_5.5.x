  <h3 class="classic-title5"><span>Flight Plan Briefing</span></h3>
	<div class="call-action call-action-boxed call-action-style1 no-descripton clearfix">
    <form id="sbapiform">
        <div class="schedule-briefing">
            <table class="briefing-table">
            	<tr>
                	<th>Airline</th>
                    <th>Flight No.</th>
                    <th>Dep ICAO</th>
                    <th>Arr ICAO</th>
                    <th>Distance</th>
                    <th>Date</th>
                    <th>Dep Time (UTC)</th>
                </tr>
                <tr>
                    <td><?php echo $schedule->code.$schedule->airline; ?></td>
                    <td><?php echo $schedule->code.$schedule->flightnum; ?></td>
                    <td><?php echo "{$schedule->depname} ($schedule->depicao)"; ?></td>
                    <td><?php echo "{$schedule->arrname} ($schedule->arricao)"; ?></td>
                    <td><?php echo "{$schedule->distance}"; ?></td>
                    <td>
                    <script>
					  $(function() {
						$( "#datepicker" ).datepicker({dateFormat: "ddMy"
						});
					  });
					</script>
                    <input name="date" size="7" type="text" id="datepicker" value="<?php echo date('dMy', time()) ?>">
                    </td>
                    <td><?php echo $schedule->deptime ?> : <?php echo $schedule->arrtime ?>

                      <!--<select name="dephour" id="dephour"><option value="0">00</option><option value="3600">01</option><option value="7200">02</option><option value="10800">03</option><option value="14400">04</option><option value="18000">05</option><option value="21600">06</option><option value="25200">07</option><option value="28800">08</option><option value="32400">09</option><option value="36000">10</option><option value="39600">11</option><option value="43200">12</option><option value="46800" selected="">13</option><option value="50400">14</option><option value="54000">15</option><option value="57600">16</option><option value="61200">17</option><option value="64800">18</option><option value="68400">19</option><option value="72000">20</option><option value="75600">21</option><option value="79200">22</option><option value="82800">23</option></select>
                      :<select name="depmin" id="depmin"><option value="0">00</option><option value="60">01</option><option value="120">02</option><option value="180">03</option><option value="240">04</option><option value="300">05</option><option value="360">06</option><option value="420">07</option><option value="480">08</option><option value="540">09</option><option value="600">10</option><option value="660">11</option><option value="720">12</option><option value="780">13</option><option value="840">14</option><option value="900">15</option><option value="960">16</option><option value="1020">17</option><option value="1080">18</option><option value="1140">19</option><option value="1200">20</option><option value="1260">21</option><option value="1320">22</option><option value="1380">23</option><option value="1440">24</option><option value="1500">25</option><option value="1560">26</option><option value="1620">27</option><option value="1680">28</option><option value="1740">29</option><option value="1800" selected="">30</option><option value="1860">31</option><option value="1920">32</option><option value="1980">33</option><option value="2040">34</option><option value="2100">35</option><option value="2160">36</option><option value="2220">37</option><option value="2280">38</option><option value="2340">39</option><option value="2400">40</option><option value="2460">41</option><option value="2520">42</option><option value="2580">43</option><option value="2640">44</option><option value="2700">45</option><option value="2760">46</option><option value="2820">47</option><option value="2880">48</option><option value="2940">49</option><option value="3000">50</option><option value="3060">51</option><option value="3120">52</option><option value="3180">53</option><option value="3240">54</option><option value="3300">55</option><option value="3360">56</option><option value="3420">57</option><option value="3480">58</option><option value="3540">59</option></select>
                    -->
                    </td>
                </tr>
            </table>
        </div>
    </div>

  <h3 class="classic-title2"><span>Flight Plan Options</span></h3>
	<div class="call-action call-action-boxed call-action-style1 no-descripton clearfix">

    	<div class="schedule-briefing">
    <table class="schedule-briefing">
        <tr>
            <td>Aircraft:</td>
            <td><?php echo $schedule->aircraft; ?> (<?php echo $schedule->registration;?>)</td>
        </tr>
        <tr>
            <td>Origin:</td>
            <td><?php echo "$schedule->depicao"; ?></td>
        </tr>
        <tr>
            <td>Destination:</td>
            <td><?php echo "$schedule->arricao"; ?></td>
        </tr>
        <tr>
            <td>Units:</td>
            <td><select id="simbrief" class="dispinput" name="units"><option value="KGS">KGS</option><option value="LBS" selected>LBS</option></select></td>
        </tr>
        <tr>
            <td>Cont Fuel: </td>
            <td><select id="simbrief" class="dispinput" name="contpct"><option value="auto" selected>AUTO</option><option value="0">0 PCT</option><option value="0.02">2 PCT</option><option value="0.03">3 PCT</option><option value="0.05">5 PCT</option><option value="0.1">10 PCT</option><option value="0.15">15 PCT</option><option value="0.2">20 PCT</option></select></td>
        </tr>
        <tr>
            <td>Reserve Fuel: </td>
            <td><select id="simbrief" class="dispinput" name="resvrule"><option value="auto">AUTO</option><option value="0">0 MIN</option><option value="15">15 MIN</option><option value="30">30 MIN</option><option value="45" selected>45 MIN</option><option value="60">60 MIN</option><option value="75">75 MIN</option><option value="90">90 MIN</option></select></td>
        </tr>
        <tr>
            <td>Detailed Navlog: </td>
            <td><input id="simbrief" type="hidden" name="navlog" value="0"><input type="checkbox" name="navlog" value="1" checked></td>
        </tr>
        <tr>
            <td>ETOPS Planning: </td>
            <td><input id="simbrief" type="hidden" name="etops" value="0"><input type="checkbox" name="etops" value="1"></td>
        </tr>
        <tr>
            <td>Plan Stepclimbs: </td>
            <td><input id="simbrief" type="hidden" name="stepclimbs" value="0"><input type="checkbox" name="stepclimbs" value="1" checked></td>
        </tr>
        <tr>
            <td>Runway Analysis: </td>
            <td><input id="simbrief" type="hidden" name="tlr" value="0"><input type="checkbox" name="tlr" value="1" checked></td>
        </tr>
        <tr>
            <td>Include NOTAMS: </td>
            <td><input id="simbrief" type="hidden" name="notams" value="0"><input type="checkbox" name="notams" value="1" checked></td>
        </tr>
        <tr>
            <td>FIR NOTAMS: </td>
            <td><input type="hidden" name="firnot" value="0"><input type="checkbox" name="firnot" value="1"></td>
        </tr>
        <tr>
            <td>Flight Maps: </td>
            <td><select id="simbrief" class="dispinput" name="maps"><option value="detail">Detailed</option><option value="simple">Simple</option><option value="none">None</option></select></td>
        </tr>
        <tr>
            <td>Plan Layout:</td>
            <td><select id="simbrief" class="dispinput" onchange="" name="planformat" id="planformat"><option value="lido" selected="">LIDO</option><option value="aal">AAL</option><option value="aca">ACA</option><option value="afr">AFR</option><option value="awe">AWE</option><option value="baw">BAW</option><option value="ber">BER</option><option value="dal">DAL</option><option value="dlh">DLH</option><option value="ezy">EZY</option><option value="gwi">GWI</option><option value="jbu">JBU</option><option value="jza">JZA</option><option value="klm">KLM</option><option value="ryr">RYR</option><option value="swa">SWA</option><option value="uae">UAE</option><option value="ual">UAL</option><option value="ual f:wz">UAL F:WZ</option></select></td>
        </tr>
    </table>
    </div>
    </div>

  <h3 class="classic-title4"><span>Route Planner</span></h3>
    <div class="call-action call-action-boxed call-action-style1 no-descripton clearfix">
        <div class="schedule-briefing">
        	<table class="schedule-briefing">
                <tr>
					<td>
                    	<span class="disphead">Route</span> (<a href="guide.php#routeguide" target="_blank">?</a>)
						<span style="font-size:14px;font-weight:bold;padding:0px 5px">&rarr;</span>
						<a href="http://flightaware.com/analysis/route.rvt?origin=<?php echo $schedule->depicao ; ?>&destination=<?php echo $schedule->arricao ; ?>" id="falink" target="_blank">
                        <img class="routeimg" src="<?php echo fileurl('/images/logos/flightaware.png');?>" alt="Flightaware" title="FlightAware"></a>
						<a href="https://skyvector.com/?chart=304&zoom=6&fpl=<?php echo $schedule->depicao ; ?>%20%20<?php echo $schedule->arricao ; ?>" id="sklink" target="_blank">
                        <img class="routeimg" src="<?php echo fileurl('/images/logos/routes_skv.png');?>" alt="SkyVector" title="SkyVector"></a>
						<a href="http://rfinder.asalink.net/free/" id="rflink" target="_blank">
                        <img class="routeimg" src="<?php echo fileurl('/images/logos/routefinder.png');?>" alt="RouteFinder" title="RouteFinder"></a>
						<!--<a target="_blank" style="cursor:pointer" onclick="validate_cfmu();">
                        <img class="routeimg" src="<?php echo fileurl('/images/logos/euro-ctl.png');?>" alt="CFMU Validation" title="CFMU Validation"></a>-->
					</td>
                </tr>
				<tr>
                    <td><textarea class="dispinput" name="route" placeholder="Enter your route here"></textarea></td>
				</tr>
                <tr>
                	<td><em><strong>Note: Remove any reference to &quot;SID&quot; &amp; &quot;STAR&quot; in your route, before generating your OFP. You may get errors if you don't.</strong></em></td>
                </tr>
			</table>
        </div>
	</div>
    	<p><strong>Note: Remember to sign up for your free <a href="http://www.simbrief.com" title="Sign up for SimBrief">SimBrief</a> account before using this feature. It won't work without it!</strong></p>

    	<button type="button" style="width:100%" onclick="simbriefsubmit('http://www.flycaribbeanva.com/phpvms/index.php/SimBrief');" value="Generate">Click to Generate OFP</button>
    </form>
