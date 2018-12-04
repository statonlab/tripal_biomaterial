# Tripal\_biomaterial

This is an extension module for the Tripal project. 

Please note this module requires **Tripal 3** or greater.  The [Tripal 2 functional module is available for download under the expression module](https://github.com/tripal/tripal_analysis_expression/releases/tag/1.0.2) but is no longer supported.

# Tripal Biomaterial

1. [Introduction](#introduction)
2. [Installation](#installation)
3. [Loading Biosamples](#loading-biosamples)
4. [Example Files](#example-files)

# Introduction 
Tripal Biomaterial is a [Drupal](https://www.drupal.org/) module built to extend the functionality of the [Tripal](http://tripal.info/) toolset.
This module provides a Tripal loader for biomaterials. This module requires the following Tripal modules:

1. Tripal
2. Tripal Chado


# Installation
1. Click on the green "Clone or download" button on the top right corner of this page to obtain the web URL. Download this module by running ```git clone <URL> ``` on command line. 
2. Place the cloned module folder "tripal_biomaterial" inside your /sites/all/modules. Then enable the module by running ```drush en tripal_biomaterial``` (for more instructions, read the [Drupal documentation page](https://www.drupal.org/node/120641)).


### Data Loader
The biosample loader has the ability to load data from an xml file downloaded from NCBI.


## Tripal 3 entities and fields

The following bundles are defined by `Tripal Protocol`

* Protocol
* Arraydesign

The following fields are defined by `Tripal Protocol` and `Tripal Biomaterial`

* Biosample Browser
    - Analysis


# Loading Biosamples
Biosamples may be loaded from a flat file or from a BioSample xml file downloaded from NCBI. The steps for loading biosamples are as follows (detailed instructions can be found further below):

1. [First download or generate the flat (.csv, .tsv) or .xml file with biosample data you want to load](#downloading-xml-biosample-file-from-ncbi).
2. Add the organism associated with the biosample if it doesn't exist yet (**Add Tripal content->Organism**).  You may also create an analysis to associate the biosamples with if you choose. 
3. Navigate to the Tripal site's Tripal Biosample Loader and
4. Submit and run the import job
5. Publish the biosamples

### Downloading XML BioSample File From NCBI
To obtain a xml BioSample file from ncbi go the [NCBI BioSample database](http://www.ncbi.nlm.nih.gov/biosample/). Search for and select the BioSamples you would like to download. 
![Select BioSamples](https://cloud.githubusercontent.com/assets/14822959/12490120/f5223ad8-c041-11e5-93ac-4692e27bf3d1.png)

Click the "Send to:" link. Then select "File" and select "Full XML (text)" as the format. Then click "Create File". 
![Download BioSample XML File](https://cloud.githubusercontent.com/assets/14822959/12490242/8cb8b796-c042-11e5-82dc-7a723867ea7a.png)

Click [here to see an example XML BioSample file from NCBI](example_files/sm125.xml).

### Using the Biosample loader
To upload the file into Chado/Tripal, navigate to:  

**Tripal->loaders->chado_biosample_loader**

First, provide the path on the server to the biosample file, or use the file uploader. You must select an Organism to associate the biosamples with.  You may also associate the imported biosamples with an analysis, but this is not required. 

Press the **Check Biosamples** button to preview your biosample properties.  To take advantage of a controlled vocabulary (CV), you must manually assign each property to a CVterm.  The uploader will list all CV terms matching each property, and provide the CV, database (DB) and accession for the match. 
If a match does not exist for your term, use the CVterm browser to identify an appropriate CVterm in your Tripal site, and rename the property in your input file to match the term.  If no term exists in your database, you should use the EBI ontology lookup serice to identify an appropriate term and insert it manually, or, load the corresponding CV.  

> ![The Biosample property configuration tool](example_files/doc_images/biosample_prop_checker.png)
> Pressing the 'Check Biosamples' button allows you to assign CVterms to every biosample property in your upload.  If there isn't a suitable CVterm, you should rename it in your upload file to match a CVterm in the database and/or insert new CVterms.


After clicking "Submit job", the page should reload with the job status and Drush command to run the job. Copy and paste the Drush command and run it on command line. Upon running the Drush command, any warning/error/success/status message should be displayed.

### Loading Biosamples From a Flat File

Altenatively biosamples may be loaded from a flat file (CSV or TSV). The flat file loader is designed to upload files that are in the [NCBI BioSample submission format](https://submit.ncbi.nlm.nih.gov/biosample/template/) which can be downloaded [here](https://submit.ncbi.nlm.nih.gov/biosample/template/). Download the TSV version of the file. The file must have a header that specifies the type of data in the column. There must be one column labeled "sample\_name". The loader will begin to collect data from the line that follows the line containing "sample\_name" which is assumed to be the header line. Columns are not required to be in any order. Other columns will be either attributes or accessions. Available NCBI [attributes](https://submit.ncbi.nlm.nih.gov/biosample/template/) can be found [here](https://submit.ncbi.nlm.nih.gov/biosample/template/). Available accession headers are bioproject\_accession, sra\_accession, biosample\_accession. All other columns will be uploaded as properties. To upload other accessions use the bulk loader provided with this module labeled, "Biomaterial Accession Term Loader". This loader will load a flat file with 3 columns (sample name, database name, accession term). A Tripal database must be created with the same name as the database name in the upload file.

Click here to see an example of a [CSV file](example_files/exampleCSV.csv) and a [TSV file](example_files/exampleTSV.tsv).

>![Biosample File Loader](example_files/doc_images/biosample_flat_loader.png)
> The Biosample loader can accept a server path, or, you can use the Tripal file uploader to directly upload files to the server.

### Publishing Biosamples to the Biological Sample Content Type

After loading, biosamples must be published to create entities for each biosample content type. As an administrator or user with correct permissions, navigate to **Content->Tripal Content->Publish Tripal Content**. Select the biological sample type to publish, apply any optional filtering, and press Publish.

### Loading a Single Biosample
Biosamples may also be loaded one at a time. As an administer or a user with permission to create Tripal content, go to: **Content->Tripal Content -> Add Tripal Content -> Biological Sample**. Available biosamples fields include the following. 
* **Accession** - If the biosample is in a database stored in your Tripal site, the accession can be entered here.  
* **Name (must be unique - required)**
* **Description** - A description of the biosample.
* **Contact** - The person or organization responsible for collecting the biosample.
* **Organism** - The organism from which the biosample was collected. 
* **Properties** - The properties describing this biosample, such as "age" or "geographic location".  Each property type utilizes a CVterm.
 
 ## Biosample properties
  
  Properties inserted into the database using the biosample bulk loader will be made available as new fields.  They can be found by going to admin->structure->Tripal Content Types -> Biological Sample and pressing the + Check for New Fields button in the upper left hand of the screen.
  
  
>  ![Existing biosample properties will be added as fields](example_files/doc_images/add_property_fields.png)
> Checking for new fields in the Structure-> Tripal Content Type admin area allows you to add existing properties to a Tripal content type.  This allows you to manually enter values during content creation, as well as configure the display. 



  If you would like to create new properties, you may do so in the structure menu.  Using the **Add New Field** row, enter the label and select **Chado Property** for the field type.  After pressing Save, you **must assign a CVterm** to this property in the Controlled Vocabulary Term section.  If an appropriate CVterm does not exist, you must insert it before you can create the field. To do so, navigate to `tripal/loaders/chado_cvterms` and press the *Add Term** button.
    
>![Creating manual Chado property fields](example_files/doc_images/create_new_chado_property_field.png)
> If a desired property field does not exist, you can create it manually in the Structure-> Tripal Content Type admin area by setting the field type to 'Chado Property'


# Example Files

### Biomaterial Loader
1. Flat files: [CSV file](example_files/exampleCSV.csv), [TSV file](example_files/exampleTSV.tsv)
2. [XML file](example_files/sm125.xml)
