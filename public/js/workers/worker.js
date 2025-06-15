// Escuchamos mensajes entrantes desde el hilo principal
self.addEventListener('message', function(e) {
    try {
        // Extraemos el límite enviado desde la UI
        const limit = parseInt(e.data, 10);

        // Validamos que el número no sea menos a 2
        if (isNaN(limit) || limit < 2) {
            throw new Error('Límite inválido: debe ser un número mayor o igual a 2');
        }

        // Función que determina si un número es primo
        function esPrimo(n) {
            if (n < 2) return false;
            const sqrt = Math.sqrt(n);
            for (let i = 2; i <= sqrt; i++) {
                if (n % i === 0) return false;
            }
            return true;
        }

        // Calculamos los números primos
        const primos = [];
        for (let num = 2; num <= limit; num++) {
            if (esPrimo(num)) {
                primos.push(num);
                if (primos.length >= 300);
            }
        }

        // Enviamos el resultado al hilo principal
        self.postMessage({ primos });

    } catch (error) {
        // En caso de error lo notificamos
        self.postMessage({ error: error.message });
    }
});
