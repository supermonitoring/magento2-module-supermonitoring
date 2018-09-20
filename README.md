Super Monitoring
Magento 2.x version Module 

Description:-

Super Monitoring is an external web application for monitoring website uptime and its basic functions.  
This plugin integrates Super Monitoring interface into WordPress administration panel so you don't have to log in to supermonitoring.com separately to see your reports or update settings.

Super Monitoring features:- 

- checking your website every minute  
- detecting different kinds of failures  
- using a worldwide network of monitoring stations to avoid false positives  
- measuring response times  
- content checking  
- web form testing  
- file integrity monitoring  
- instant email & mobile text (SMS) alerts  
- unlimited event history  
- API.

Installation: -

1. Upload app Folder in to server root Folder














2. Run Below Command from Terminal /Cmd /SSH /Putty
	
	=> php bin/magento setup:upgrade
	=> php bin/magento setup:static-content:deploy -f (with Locale code )
	=> php bin/magento cache:clean



Configuration Guide :-

1. Create an account in http://supermonitoring.com
2. After login click on Your Account
3. Copy token from



4. Put in Authorization token in Store configuration




Then Refresh cache .

5. You can check Reports->Super Monitoring->Your checks
























