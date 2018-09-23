<?php
/**
 * Parameters 
 * mesaureUnit : The unit of measurement Ex: 'b' will show 123.45b,
 * unitSize : The size of the multiplier Ex: 1024 is for bytes, so 4096 will show 4K
 * maxDepth : 0-normal, 1 until K, 2 until M, 3 until G, 4 until T
 * prefix : Text before result
 * suffix : Text after result
*/

    $bytesLength = strlen($fieldValue);
    $unitSize = ( empty($fieldDef['unitSize']) ? 1000 : $fieldDef['unitSize'] );
    $unitDefault = ( empty($fieldDef['mesaureUnit']) ? '' : $fieldDef['mesaureUnit'] );    
    $unitName = $unitDefault;
    
    if(( $fieldDef['maxDepth'] > 0 ) && ( $bytesLength > $unitSize*2 )) {
        $bytesLength=round($bytesLength/$unitSize,2);
        $unitName = 'K' . $unitDefault;
    }
    
    if(( $fieldDef['maxDepth'] > 1 ) && ( $bytesLength > $unitSize*2 )) {
        $bytesLength=round($bytesLength/$unitSize,2);
        $unitName = 'M' . $unitDefault;
    }
    
    if(( $fieldDef['maxDepth'] > 2 ) && ( $bytesLength > $unitSize*2 )) {
        $bytesLength=round($bytesLength/$unitSize,2);
        $unitName = 'G' . $unitDefault;
    }
    
    if(( $fieldDef['maxDepth'] > 3 ) && ( $bytesLength > $unitSize*2 )) {
        $bytesLength=round($bytesLength/$unitSize,2);
        $unitName = 'T' . $unitDefault;
    }
    echo $fieldDef['prefix'].$bytesLength.$unitName.$fieldDef['suffix'];
?>