<?php
if($_POST)
{
    $a1=0;
    move_uploaded_file($_FILES['fileToUpload']['tmp_name'],"geo.csv");
    $file = fopen("geo.csv","r");
    $csv_array=fgetcsv($file,1000,",");
    while (($data = fgetcsv($file, 1000, ",")) !== FALSE)
    {
        $feature[]=[
            'type' => 'Feature',
            'geometry' => array(
                'type' => 'LineString',
                # Pass Longitude and Latitude Columns here
                'coordinates' => [[(float)$data[3],(float)$data[2]],[(float)$data[8],(float)$data[7]]]
            ),
            # Pass other attribute columns here
            'properties' => [''=>'']
        ];
    }
    $geojson = array(
        'type'      => 'FeatureCollection',
        'features'  => $feature
    );
    fclose($h);
    header('Content-disposition:attachment;filename=geo.geojson');
    header('Content-type:application/json');
    echo(json_encode($geojson));
    exit();
}
?>
<!DOCTYPE html>
<html>
<body>

<form action="/" method="post" enctype="multipart/form-data">
    Select GEO CSV to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload GEO CSV" name="submit">
</form>

</body>
</html>
