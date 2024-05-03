<?php

function removerVaga()
{
   try {
       $pdo = new PDO("sqlite:db.sqlite");
       $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       
       echo "Digite o valor que deseja consultar: ";
       $buscar = trim(fgets(STDIN));

       $sqlListName = "SELECT v.id, v.titulo, e.nome 
                       FROM vaga v 
                       INNER JOIN empresa e ON e.id = v.empresa_id 
                       WHERE v.titulo LIKE :curinga OR v.email LIKE :curinga OR e.email LIKE :curinga OR e.nome LIKE :curinga";

       $stmt = $pdo->prepare($sqlListName);
       // bindParam parecido com replace
       $stmt->bindValue(':curinga', "%{$buscar}%"); // usar bindValue ao invés de bindParam
       $stmt->execute();

       // configura os dados consultados como uma matriz
       $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

       if (empty($results)) {
           die("Nenhuma vaga encontrada com os termos de busca!\n");
       }

       array_walk($results, function($element){
           echo join("\t", $element);
           echo "\n";
       });

       echo "Digite o ID da vaga que deseja remover: ";
       $removerVagaID = trim(fgets(STDIN));

       $existeVaga = false;

       array_walk($results, function($element) use(&$existeVaga, $removerVagaID){
           if ($element['id'] == $removerVagaID) {
               $existeVaga = true;
           }
       });

       if ($existeVaga == false) {
           die("Vaga não existe seu animal!\n");
       }

       echo "Tem certeza? s/n: ";
       $confirmarRemocao = strtolower(trim(fgets(STDIN)));

       if ($confirmarRemocao == "s") {
           $sql = "DELETE FROM vaga WHERE id = $removerVagaID";
           $stmt = $pdo->prepare($sql);
           $stmt->execute();
           echo "Removido com sucesso!\n";
       } else {
           echo "Valor não removido!\n";
       }

   } catch(PDOException $e) {
       echo "Erro: " . $e->getMessage();
   } 
}