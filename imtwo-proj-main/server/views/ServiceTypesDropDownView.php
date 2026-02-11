<?php
require_once __DIR__."/../repository/ServiceTypeRepository.php";
$serviceTypeRepository = new ServiceTypeRepository();
$serviceTypeList = $serviceTypeRepository->getAll();

foreach($serviceTypeList as $serviceType):?>
<option value="<?php echo $serviceType->ID?>" data-value="<?php echo $serviceType->ValuePerKG?>"><?php echo $serviceType->Name ?></option>

<?php endforeach; ?>