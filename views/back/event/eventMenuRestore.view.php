<h1>Event</h1>

<table class="table">

    <?php

    echo "<thead><tr>";
    foreach ($search as $key){
        echo "<th>";
        echo $key;
        echo "</th>";
    }
    echo "<th colspan='2'>Actions</th>";
    echo "</tr></thead>";


    foreach($result as $event)
    {
        echo "<tr>";

        foreach ($event as $eventinfo)
        {
            echo "<td>";
            echo $eventinfo;
            echo "</td>";
        }
        echo "<td>";
        echo "<a class='table-button restore' href='actionRestore/" . $event['id'] . "'> Restaurer </a>";
        echo "</td>";

        echo "</tr>";
    }
    ?>

</table>