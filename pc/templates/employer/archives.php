 <style type="text/css">
 h1{
     margin: 1em 0;
 }
 h1 a{
     border-radius: 2px;
     margin: 1em 0;
 }
 table{
     border-spacing: 1px;
     border-collapse: collapse;
     min-width: 100%;
     font-size: 90%;
 }
 thead{
     text-align: left;
 }
 th{
    padding: 5px 15px;
    border: 1px solid #e7e7e7;
    height: 2.5em;
    border-bottom-color: #c8c8c8;
    color: #123168;
 }
 td{
    vertical-align: middle;
    height: 2em;
    border: 1px solid #e7e7e7;
    padding: 10px 3px;
    text-align: center;
 }
 .job-active, .job-closed{
     font-size: .8em;
     color: white;
     padding: 3px 8px;
     border-radius: 1px;
 }
 .job-active{
     background: #42b28c;
 }
 .job-closed{
     background: #bc2036;
 }
 .emp-button{

 }
 </style>
 <div>
 <h1>Listings
   <span style="float: right; font-size: .6em;" class="button emp-button">
       <a href="addproject">New Listing</a>
   </span>
 </h1>
 </div>
 <table>
 <thead>
 <tr>
   <th style="text-align: center;"><input type="checkbox" name="" id="check_all"></th>
   <th>Title</th>
   <th>Applications</th>
   <th>Status</th>
   <th>Posted On</th>
   <th>Expires</th>
   <th>Actions</th>
 </tr>
 </thead>
 <tbody>
 <?php
 if(!empty($jobs)) {
     foreach ($jobs as $job) {
         $title = truncate($job->title, 40, "...");
         $bids = $job->getBids(1, 15);
         $bids = $bids['num_rows'];
         $status = ($job->status == 1) ? "<span class='job-active'>Active</span>" : "<span class='job-closed'>Closed</span>";
         $postedDate = dateToYMD($job->postedDate, "Y-m-d");
         $expiry = dateToYMD($job->expiryDate,'Y-m-d');

         ?>
         <tr>
             <td><label for="check_all" <input type="checkbox" value="" id="check_all" disabled></td>
             <td style="text-align: left;"><?php echo $title; ?></td>
             <td><?php echo $bids; ?></td>
             <td><?php echo $status; ?></td>
             <td><?php echo $postedDate; ?></td>
             <td><?php echo $expiry; ?></td>
             <td>
                 <a href="myproject/<?php echo $job->jobId;?>" class="action-c" style="background: cornflowerblue;" title="View">
                    <span class="fa fa-eye"></span>
                 </a>
                 <a href="?controller=job&amp;action=edit&amp;job_id=<?php echo $job->jobId;?>" class="action-c" style="background: #42b28c;" title="Edit">
                    <span class="fa fa-pencil"></span>
                 </a>
                 <a href="#" style="background: #bc2036;" title="Delete" class="action-c">
                    <span class="fa fa-trash"></span>
                 </a>
             </td>
         </tr>
     <?php
     }
     ?>
     </tbody>
     </table>
 <?php
 }else {
     ?>
     <h1 style="position: absolute; left: 40%; top: 10em; color: #c8c8c8;">You have not posted any project.</h1>
 <?php
 }