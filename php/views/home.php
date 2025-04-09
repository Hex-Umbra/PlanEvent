<?php
   $events = $eventController->getAllEventsByDate();
   if(isset($events["error"])){
      echo $events["error"];
   }
?>

<div class="events-body">

   <div class="events-container">

      <?php foreach ($events as $event): ?>
         <div class="event-card">
            <img src=<?= $event["image_url"] ?> alt="">
            <div class="card-content">
               <h3><?= $event['name'] ?></h3>
               <div>
                  <p><?= $event["date"] ?> </p>
                  <p><?= substr($event["time"], 0, 5) ?> </p>
                  <p><?= $event["location"] ?> </p>
               </div>
            </div>
            <div class="card-description">
               <p><?= $event["description"] ?>
               </p>
            </div>
            <div class="card-footer">
               <span class="badge">Places: <?= $event["places_available"] ?> </span>
               <span class="badge"><?= $event["price"] ?>€ </span>
               <a href="?page=event&id_event=<?= $event['id_event'] ?>">
                  More Details
               </a>

            </div>
            <p class="org-name"><?= $event["org_name"] ?> </p>
         </div>
      <?php endforeach; ?>


   </div>
</div>