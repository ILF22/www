<?php
// PILA TIPO FIFO
  $pila = []; // Definimos un array vacio

// Insertamos 2 elementos en la pila
  array_push($pila, 1, 2);
// Insertamos 1 elemento
  array_push($pila, 3);
// Mostramos contenido de la pila [5, 10,  50]
  print_r($pila);

// Extraemos elemento (primero) comprobando  que existen elementos
  if(count($pila)>0):
    $elemento = array_shift($pila);
    echo "Extraido: $elemento<br>"; // 5 
  else:
    echo "Pila vacía.<br>";
  endif; 
// Mostramos contenido de la pila [10, 50]
  print_r($pila);

// Añadimos dos elementos nuevos
  array_push($pila, 4, 5);
// Mostramos contenido de la pila [10, 50,  15, 60]
  print_r($pila);

// Extraemos 3 elementos
  for($i=0;$i<3;$i++):
    if(count($pila)>0):
      $elemento = array_shift($pila);
      echo "Extraido: $elemento<br>"; // 5 
    else:
      echo "Pila vacía.<br>";
      break;
    endif; 
  endfor;
// Mostramos contenido de la pila [60]
  print_r($pila);

// Intentamos extraer 2 elementos (sólo  podremos extraer uno)
  for($i=0;$i<2;$i++):
    if(count($pila)>0):
      $elemento = array_shift($pila);
      echo "Extraido: $elemento<br>"; // 5 
    else:
      echo "Pila vacía.<br>";
      break;
    endif; 
  endfor;
?>