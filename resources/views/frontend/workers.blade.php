<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Web Workers – Primos Moderno</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">


</head>
<body>
    <div class="card card-primos border-success">

   <div class="card card-primos border-success">
        <div class="header-section">
            <h2 class="mb-0 text-success">Web Workers – Números Primos</h2>
        </div>

        <div class="card-body">
            <div class="form-floating mb-4">
                <input
                type="number"
                class="form-control p-3 border-success text-success"
                id="entradaLimite"
                placeholder="Límite hasta"
                min="2"
                style="height: 5rem;"
                >
                <label for="entradaLimite" class="text-success">
                Ingrese el número hasta el cual quiere calcular
                </label>
            </div>
        <div class="d-grid mb-4">
            <button id="botonIniciar" class="btn btn-success btn-lg">
            Calcular Primos
            </button>
        </div>
        <div id="estado" class="text-center mb-3" style="min-height:2.5rem;"></div>
        <ul id="listaPrimos" class="list-group"></ul>
        </div>
    </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const entradaLimite = document.getElementById('entradaLimite');
      const botonIniciar  = document.getElementById('botonIniciar');
      const estado        = document.getElementById('estado');
      const listaPrimos   = document.getElementById('listaPrimos');
      let trabajador;

      botonIniciar.addEventListener('click', function() {
        try {
          const limite = parseInt(entradaLimite.value, 10);
          if (isNaN(limite) || limite < 2) {
            throw new Error('Ingresa un número válido (≥ 2).');
          }

          // Mostrar spinner y deshabilitar botón
          estado.innerHTML = `
            <div class="d-flex justify-content-center">
              <div class="spinner-border text-success" role="status"></div>
              <span class="ms-2 text-dark">Calculando…</span>
            </div>`;
          botonIniciar.disabled = true;
          listaPrimos.innerHTML = '';

          if (trabajador) trabajador.terminate();
          trabajador = new Worker('/js/workers/worker.js');

          trabajador.addEventListener('message', function(e) {
            const { primos, error } = e.data;
            botonIniciar.disabled = false;
            if (error) {
              estado.innerHTML = `<span class="text-danger">Error: ${error}</span>`;
            } else {
              estado.innerHTML = `<span class="text-dark">Completado: ${primos.length} primos</span>`;
              primos.forEach(p => {
                const li = document.createElement('li');
                li.textContent = p;
                li.classList.add('list-group-item');
                listaPrimos.appendChild(li);
              });
            }
            trabajador.terminate();
          });

          trabajador.postMessage(limite);

        } catch (err) {
          botonIniciar.disabled = false;
          estado.innerHTML = `<span class="text-danger">Error: ${err.message}</span>`;
        }
      });
    });
  </script>
</body>
</html>
