<?php
namespace Tests;

use StatonLab\TripalTestSuite\DBTransaction;
use StatonLab\TripalTestSuite\TripalTestCase;

class TripalBiomaterialLoaderTest extends TripalTestCase {
   use DBTransaction;



  /**
   * @group biomaterial
   * @group importer
   */
   public function test_biomats_are_loaded(){

     $organism = factory('chado.organism')->create();
     $analysis = factory('chado.analysis')->create();

     $file = ['file_local' => __DIR__ .'/../example_files/biomaterials_example.xml'];

     $run_args = [
       'organism_id' => $organism->organism_id,
       'analysis_id' => $analysis->analysis_id,
     ];

     module_load_include('inc', 'tripal_biomaterial', 'includes/TripalImporter/tripal_biomaterial_loader_v3');

     $importer = new \tripal_biomaterial_loader_v3();
     $importer->create($run_args, $file);
     $importer->prepareFiles();
     $importer->run();


     $results = db_select('chado.biomaterial', 'b')
       ->fields('b')
       ->condition('taxon_id', $organism->organism_id)
       ->execute()
       ->fetchAll();

     $this->assertNotFalse($results);
     $this->assertNotEmpty($results);
     $this->assertEquals(5, count($results));
   }

  /**
   * @group wip
   */
   public function test_parse_xml_biomaterial_file(){
     $file =  __DIR__ .'/../example_files/biomaterials_example.xml';

     module_load_include('inc', 'tripal_biomaterial', 'includes/TripalImporter/tripal_biomaterial_loader_v3');

     $importer = reflect(new \tripal_biomaterial_loader_v3());

    $out =  $importer->parse_xml_biomaterial_file($file);
     $fields = $out["attributes"];
     $this->assertArrayHasKey('camera', $fields);
     $this->assertArrayHasKey('city', $fields);
   }
}
