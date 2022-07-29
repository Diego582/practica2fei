#!/bin/bash
nombreProyecto=$1  # la variable toma el primer valor que le pasamos al script
cd ..
ruta=$PWD  # la variable toma el segundo valor que le pasamos al script
cantidad=${#ruta}
echo $nombreProyecto

echo $num2

echo $path

echo $cantidad

echo $rutaAnterior

echo 'docker run --rm -v "'$ruta''/''$nombreProyecto'/frontend:/'$nombreProyecto'" -w "/'$nombreProyecto'" -it node:17.8.0-alpine3.14 sh -c "npm install -g @vue/cli && vue create ."'




