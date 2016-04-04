<!doctype html>
<html lang="en">
 <head>
  <meta charset="UTF-8">
  <title>
   Laravel
  </title>
 </head>
 <body>
  <form action="{{ url('formstore') }}" method="post">
   <input type='text' name='var3' value='hello' />
   <input type='text' name='var4' value='clivern' />
   <input type='submit' value='Submit' />
  </form>
 </body>