PHP ArcIMS API

Created by Christopher Casad, Genex Systems (http://www.genex-systems.com), while contracting with NASA Langley Research Center's Geographic Information System Team (http://www.larc.nasa.gov).

This API was created to help build ESRI ArcIMS websites using PHP and is publicly available under The GNU General Public License (GPL) (http://www.opensource.org/licenses/gpl-license.html).

The core connector code (src/lib/phparcimsapi/api/connector.php), which communicates with ArcIMS, was originally created by United States Department of Transportation Bureau of Transportation Statistics (http://www.bts.gov) and its contract staff from INDUS Corporation (http://www.induscorp.com).


/*************************************************************************/

Original comments for the core connector code from INDUS Corporation:

v1, 7/23/02 ArcIMS PHP Connector 

Background: 
  
From mid-2000 through 2001, INDUS contract staff wrote a set of ArcIMS applications for the Intermodal Transportation Database (ITDB) project using the ESRI HTMLViewer 3.0.  For the next generation of ITDB, TranStats, BTS was looking for a high-speed, thin client to use for dynamic mapping against the many different datasets in the TranStats database.  The HTMLViewer, with its thousands of lines of javascript and use of client-side XML parsing, was deemed inappropriate.  Because our site's platform is Sun Solaris 7 (the ActiveX Connector was thus not an option) and we were already using PHP for parts of our application system, we opted to try putting together a proof-of-concept PHP application.  This was successful and the decision was made to try to implement enough of a connector to duplicate the functions in our HTMLViewer applications.  Those rewritten applications are now online and available to the public. 
  
The code in the PHP Connector is publicly available, having been developed by BTS and its contract staff.

/*************************************************************************/
