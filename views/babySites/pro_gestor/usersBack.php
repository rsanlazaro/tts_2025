<?php
// Make sure the response is plain text (not HTML)
header('Content-Type: text/plain');

// Read the raw POST body
$input = json_decode(file_get_contents('php://input'), true);

// Extract values
if (isset($_POST['function'])) {
    $function = $_POST['function'];
} else {
    $function = $input['function'] ?? 'No function value';
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include "../../../includes/app.php";
    $conn = connectDB();

    if ($function == 'toggleAccess') {
        $id = $input['id'] ?? 'No id value';
        $newValue = $input['newValue'] ?? 'No newValue value';
        $column = $input['column'] ?? 'No column value';
        if (isset($id)) {
            $query = "UPDATE access SET $column = '${newValue}' WHERE id = ${id}";
            $result = mysqli_query($conn, $query);
        }
    }

    if ($function == 'toggleAccess2') {
        $id = $input['id'] ?? 'No id value';
        $newValue = $input['newValue'] ?? 'No newValue value';
        $column = $input['column'] ?? 'No column value';
        if (isset($id)) {
            $query = "UPDATE users SET $column = '${newValue}' WHERE id = ${id}";
            $result = mysqli_query($conn, $query);
        }
    }

    if ($function == 'deleteSelected') {
        $page = $input['page'];
        $ids = $input['id'];
        $idsSQL = '(';
        $count = 0;
        foreach ($ids as $id) {
            $count++;
            if ($count > 1) {
                $idsSQL = $idsSQL . ', ';
            }
            $idsSQL = $idsSQL . filter_var($id, FILTER_VALIDATE_INT);
        }
        $idsSQL = $idsSQL . ')';
        if (isset($ids)) {
            $query = "DELETE FROM $page WHERE id IN ${idsSQL}";
            echo "Query: $query\n";
            $result = mysqli_query($conn, $query);
        }
    }

    if ($function == 'delete') {
        $page = $input['page'];
        $id = $input['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if (isset($id)) {
            $query = "DELETE FROM $page WHERE id = ${id}";
            $result = mysqli_query($conn, $query);
        }
    }

    if ($function == 'insert') {
        $page = $input['page'];
        $today = date("Y-m-d H:i:s");
        if ($page == 'users') {
            $sql = "SELECT * FROM access WHERE id=1";
            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
                for ($i = 1; $i <= 100; $i++) {
                    ${"access_" . $i} = $row["recluta" . '_' . $i];
                }
            }
            $sql = "INSERT INTO $page (username, password, created_on, profile, access_1, access_2, access_3, access_4, access_5, access_6, access_7, access_8, access_9, access_10, access_11, access_12, access_13, access_14, access_15, access_16, access_17, access_18, access_19, access_20, access_21, access_22, access_23, access_24, access_25, access_26, access_27, access_28, access_29, access_30, access_31, access_32, access_33, access_34, access_35, access_36, access_37, access_38, access_39, access_40, access_41, access_42, access_43, access_44, access_45, access_46, access_47, access_48, access_49, access_50, access_51, access_52, access_53, access_54, access_55, access_56, access_57, access_58, access_59, access_60, access_61, access_62, access_63, access_64, access_65, access_66, access_67, access_68, access_69, access_70, access_71, access_72, access_73, access_74, access_75, access_76, access_77, access_78, access_79, access_80, access_81, access_82, access_83, access_84, access_85, access_86, access_87, access_88, access_89, access_90, access_91, access_92, access_93, access_94, access_95, access_96, access_97, access_98, access_99, access_100)
            VALUES ('-', '-', '${today}', 'recluta', '${access_1}', '${access_2}', '${access_3}', '${access_4}', '${access_5}', '${access_6}', '${access_7}', '${access_8}', '${access_9}', '${access_10}', '${access_11}', '${access_12}', '${access_13}', '${access_14}', '${access_15}', '${access_16}', '${access_17}', '${access_18}', '${access_19}', '${access_20}', '${access_21}', '${access_22}', '${access_23}', '${access_24}', '${access_25}', '${access_26}', '${access_27}', '${access_28}', '${access_29}', '${access_30}', '${access_31}', '${access_32}', '${access_33}', '${access_34}', '${access_35}', '${access_36}', '${access_37}', '${access_38}', '${access_39}', '${access_40}', '${access_41}', '${access_42}', '${access_43}', '${access_44}', '${access_45}', '${access_46}', '${access_47}', '${access_48}', '${access_49}', '${access_50}', '${access_51}', '${access_52}', '${access_53}', '${access_54}', '${access_55}', '${access_56}', '${access_57}', '${access_58}', '${access_59}', '${access_60}', '${access_61}', '${access_62}', '${access_63}', '${access_64}', '${access_65}', '${access_66}', '${access_67}', '${access_68}', '${access_69}', '${access_70}', '${access_71}', '${access_72}', '${access_73}', '${access_74}', '${access_75}', '${access_76}', '${access_77}', '${access_78}', '${access_79}', '${access_80}', '${access_81}', '${access_82}', '${access_83}', '${access_84}', '${access_85}', '${access_86}', '${access_87}', '${access_88}', '${access_89}', '${access_90}', '${access_91}', '${access_92}', '${access_93}', '${access_94}', '${access_95}', '${access_96}', '${access_97}', '${access_98}', '${access_99}', '${access_100}');";
        } else {
            $sql = "INSERT INTO $page (username, password, created_on, profile)
            VALUES ('-', '-', '${today}', 'ip');";
        }
        $result = mysqli_query($conn, $sql);
    }

    if ($function == 'update') {
        $page = $input['page'];
        $id = $input['id'] ?? 'No id value';
        $newValue = $input['newValue'] ?? 'No newValue value';
        $column = $input['column'] ?? 'No column value';
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if ($column == 'profile') {
            if (isset($id)) {
                $query = "UPDATE $page SET $column = '${newValue}' WHERE id = ${id}";
                $result = mysqli_query($conn, $query);
                $query = "SELECT * FROM access WHERE id=1";
                $result = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_assoc($result)) {
                    for ($i = 1; $i <= 100; $i++) {
                        ${"access_" . $i} = $row[$newValue . '_' . $i];
                    }
                }
                $query = "UPDATE users 
                    SET access_1 = '${access_1}', access_2 = '${access_2}', access_3 = '${access_3}', access_4 = '${access_4}', access_5 = '${access_5}', access_6 = '${access_6}', access_7 = '${access_7}', access_8 = '${access_8}', access_9 = '${access_9}', access_10 = '${access_10}',
                        access_11 = '${access_11}', access_12 = '${access_12}', access_13 = '${access_13}', access_14 = '${access_14}', access_15 = '${access_15}', access_16 = '${access_16}', access_17 = '${access_17}', access_18 = '${access_18}', access_19 = '${access_19}', access_20 = '${access_20}',
                        access_21 = '${access_21}', access_22 = '${access_22}', access_23 = '${access_23}', access_24 = '${access_24}', access_25 = '${access_25}', access_26 = '${access_26}', access_27 = '${access_27}', access_28 = '${access_28}', access_29 = '${access_29}', access_30 = '${access_30}',
                        access_31 = '${access_31}', access_32 = '${access_32}', access_33 = '${access_33}', access_34 = '${access_34}', access_35 = '${access_35}', access_36 = '${access_36}', access_37 = '${access_37}', access_38 = '${access_38}', access_39 = '${access_39}', access_40 = '${access_40}',
                        access_41 = '${access_41}', access_42 = '${access_42}', access_43 = '${access_43}', access_44 = '${access_44}', access_45 = '${access_45}', access_46 = '${access_46}', access_47 = '${access_47}', access_48 = '${access_48}', access_49 = '${access_49}', access_50 = '${access_50}',
                        access_51 = '${access_51}', access_52 = '${access_52}', access_53 = '${access_53}', access_54 = '${access_54}', access_55 = '${access_55}', access_56 = '${access_56}', access_57 = '${access_57}', access_58 = '${access_58}', access_59 = '${access_59}', access_60 = '${access_60}',
                        access_61 = '${access_61}', access_62 = '${access_62}', access_63 = '${access_63}', access_64 = '${access_64}', access_65 = '${access_65}', access_66 = '${access_66}', access_67 = '${access_67}', access_68 = '${access_68}', access_69 = '${access_69}', access_70 = '${access_70}',
                        access_71 = '${access_71}', access_72 = '${access_72}', access_73 = '${access_73}', access_74 = '${access_74}', access_75 = '${access_75}', access_76 = '${access_76}', access_77 = '${access_77}', access_78 = '${access_78}', access_79 = '${access_79}', access_80 = '${access_80}',
                        access_81 = '${access_81}', access_82 = '${access_82}', access_83 = '${access_83}', access_84 = '${access_84}', access_85 = '${access_85}', access_86 = '${access_86}', access_87 = '${access_87}', access_88 = '${access_88}', access_89 = '${access_89}', access_90 = '${access_90}',
                        access_91 = '${access_91}', access_92 = '${access_92}', access_93 = '${access_93}', access_94 = '${access_94}', access_95 = '${access_95}', access_96 = '${access_96}', access_97 = '${access_97}', access_98 = '${access_98}', access_99 = '${access_99}', access_100 = '${access_100}'
                    WHERE id = ${id}";
                $result = mysqli_query($conn, $query);
            }
        } else {
            if (isset($id)) {
                $query = "UPDATE $page SET $column = '${newValue}' WHERE id = ${id}";
                $result = mysqli_query($conn, $query);
            }
        }
        echo "Received ID: $id with column $column and newValue $newValue from page $page";
    }
}
