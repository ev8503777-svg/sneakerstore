from collections import deque

def verificador_estado(estructura_cola, valor_objetivo):
    cola_aux = deque(estructura_cola)
    encontrado = False
    while cola_aux:
        elemento = cola_aux.popleft()
        if elemento == valor_objetivo:
            encontrado = True
    return encontrado

# --- Prueba de la función ---
mi_cola = deque([1, 2, 3, 4, 5])
resultado = verificador_estado(mi_cola, 3)
print(resultado)  # Imprime: True

resultado2 = verificador_estado(mi_cola, 9)
print(resultado2)  # Imprime: False