<?php
    include_once($_SERVER['DOCUMENT_ROOT'] . '/als/Enviroment/DbContext.php');

    $response = "";
    $dbContext = new DbContext();
    $courseId = $_POST["cId"];
    $selectStatement = "SELECT * FROM lessons WHERE course_id=" . $courseId;
    $lessonsList = $dbContext -> Select($selectStatement);
    
    while ($row = $lessonsList -> fetch_assoc())
    {
        $lessonId = $row["id"];
        $lessonTitle = $row["title"];
        $courseId = $row["course_id"];
        $countOfModules = $row["count_of_modules"];
        $insertDate = $row["insert_time"];

        $response = $response . '<div class="well well-md">
									<h4 >Lekcja - <i>'. $lessonTitle .'</i></h4>
									<div id="courseId" style="display:none;">'. $courseId .'</div>
									<table class="table table-hover">
										<thead>
											<tr>
												<th>Tytuł</th>
												<th>Ilość modułów</th>
												<th>Data utworzenia</th>
												<th>Usuń</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>
													<div class="form-inline">
														<input id="title'. $lessonId .'" type="text" value="'. $lessonTitle .'"  class="form-control" >
														<button class="btn btn-sm btn-primary" onclick=lessonChangeTitle('. $lessonId .')>Zmień</button>
													</div>
												</td>
												<td>
													<div class="form-inline">
														<input id="'. $lessonId .'" type="number" value="'. $countOfModules .'" min="1"  class="form-control" >
														<button class="btn btn-sm btn-warning" onclick=lessonChangeCountOfModules('. $lessonId .')>Zmień</button>
													</div>
												</td>
												<td>'. $insertDate .'</td>
												<td>'. '<button class="btn btn-danger" onclick="DeleteLesson('. $lessonId .')">Usuń</button>' .'</td>
											</tr>
										</tbody>
									</table>
									<hr/>';
		
		$response = $response . '<h4>Moduły lekcji</h4>
											<table class="table table-hover">
												<thead>
													<tr>
														<th>Tytuł modułu</th>
														<th>Kolejność</th>
														<th>Styl nauczania</th>
														<th>Edycja</th>
														<th>Usuń</th>
													</tr>
												</thead>
												<tbody>';
		
		$selectStatement = 'SELECT * FROM modules WHERE lesson_id=' . $lessonId . ' ORDER BY order_num';
		$modulesList = $dbContext -> Select($selectStatement);
		while ($rowMod = $modulesList -> fetch_assoc())
		{
			$idModul = $rowMod['id'];
			$titleModul = $rowMod['title'];
			$contentModul = $rowMod['content'];
			$orderNum_Modul = $rowMod['order_num'];
			$learningstyleId = $rowMod['learningstyle_id'];
			$learningstyleText = "";
			
			if($learningstyleId == 1)
				$learningstyleText = "Wzrokowiec";
			else if ($learningstyleId == 2)
				$learningstyleText = "Słuchowiec";
			else if ($learningstyleId == 3)
				$learningstyleText = "Tekściarz";
			else if ($learningstyleId == 4)
				$learningstyleText = "Kinestetyk";
			else if ($learningstyleId == 5)
				$learningstyleText = "Wszyscy";
				
			
			//TO-DO : porobic funckje w learning style
			
			$response = $response .			'		<tr>
														<td>
															<div class="form-inline">
																<input id="modtitle'. $idModul .'" type="text" value="'. $titleModul .'"  class="form-control" >
																<button class="btn btn-sm btn-primary" onclick=moduleChangeTitle('. $idModul .')>Zmień</button>
															</div>
														</td>
														<td>
															<div class="form-inline">
																<input id="modQueue'. $idModul .'" type="number" value="'. $orderNum_Modul .'" min="1" max="'. $countOfModules .'"  class="form-control" >
																<button class="btn btn-sm btn-warning" onclick=moduleChangeCountOfModules('. $idModul .')>Zmień</button>
															</div>
														</td>
														<td>
															<div class="dropdown disabled">
																<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">'. $learningstyleText .'
																<span class="caret disabled"></span></button>
																<ul id="" class="dropdown-menu" >
																	<li><a onclick="UpdateLearningStyleForModule(' . $idModul . ', ' . 1 . ')" style="cursor: pointer">'. 'Wzrokowiec' .'</a></li>
																	<li><a onclick="UpdateLearningStyleForModule(' . $idModul . ', ' . 2 . ')" style="cursor: pointer">'. 'Słuchowiec' .'</a></li>
																	<li><a onclick="UpdateLearningStyleForModule(' . $idModul . ', ' . 3 . ')" style="cursor: pointer">'. 'Tekściarz' .'</a></li>
																	<li><a onclick="UpdateLearningStyleForModule(' . $idModul . ', ' . 4 . ')" style="cursor: pointer">'. 'Kinestetyk' .'</a></li>
																	<li><a onclick="UpdateLearningStyleForModule(' . $idModul . ', ' . 5 . ')" style="cursor: pointer">'. 'Wszyscy' .'</a></li>
																</ul>
															</div>
														</td>
														<td>'. '<a class="btn btn-warning" href="index.php?con=5&page=98&edit=' . $idModul . '">Edytuj</a>' .'</td>
														<td>'. '<button class="btn btn-danger" onclick="DeleteModule('. $idModul .')">Usuń</button>' .'</td>
													</tr>';
		}
		
			$response = $response . '			</tbody>
											</table>
										</div>';
	}

    echo $response;
?>