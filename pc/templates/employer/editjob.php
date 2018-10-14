<?php
if($jobId == ""){
    ?>
    <div class="col-4 blank centered" style="min-height: 220px;">
        No project selected. To edit a project, click on the eye
        (<span class="fa fa-eye"></span>) icon associated with the project on
        <a href="myprojects">My Projects</a> page.
    </div>
<?php
}
else {

    ?>
    <style type="text/css">
        .col-4 {
            background: rgba(0, 0, 0, 0.04);
            border: 1px solid rgba(0, 0, 0, 0.1);
            min-height: 550px;
        }

        form * {
            line-height: 2;
        }

        form input[type="text"], form input[type="number"], form input[type="password"], form input[type="date"], textarea {
            padding: 5px 10px;
            width: 80%;
        }

        form input[type="checkbox"] {
            margin: 0;
            padding: 0;
            border: 0;
        }

        form select {
            color: black;
        }

        textarea {
            height: 150px;
            margin-left: 3em;
            resize: none;
        }

        #range {
            margin-bottom: 100px;
        }

        #range .col-2 {
            padding: 0;
            margin-bottom: 1em;
        }
    </style>

    <form action="<?php htmlspecialchars($_SERVER['REQUEST_URI']); ?>" method="post" enctype="multipart/form-data">
        <div> class="col-4">
            <?php
            if (isset($_SESSION['error'])) {
                echo "<div class='error'>{$_SESSION['error']}</div>";
                unset($_SESSION['error']);
            }
            ?>
            <div class="col-6">
                <label for="title">Title:
                    <input type="text" name="title" placeholder="Title" value="<?= $project->title; ?>">
                </label>
                <label for="description"></label>

                <p>Description: </p>
                <textarea id="description" name="description"><?= $project->description ?></textarea>
                <label for="req"></label>

                <p>Requirements:</p>
                <textarea id="req" name="requirements"><?= $project->requirements; ?></textarea>
                <br/>
                <br/>
                <label for="expiry">Expires: </label>
                <input type="date" name="expiry_date" id="expiry" style="width: 150px;">
                <br/>
                <br/>
                <button class="button" type="submit" name="update" value="Update">Update</button>
            </div>
        </div>
    </form>
    <?php
}