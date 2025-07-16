<?php
require_once __DIR__."/../repository/StatusRepository.php";
$statusRepository = new StatusRepository();
$statusList = $statusRepository->getAll();

foreach($statusList as $status):?>
<option value="<?php echo $status->ID?>" ><?php echo $status->Name ?></option>

<?php endforeach; ?>