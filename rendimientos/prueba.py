import psutil
import json

from pynvml import nvmlInit, nvmlDeviceGetHandleByIndex, nvmlDeviceGetUtilizationRates
nvmlInit()  # Inicializar la librería de NVIDIA
handle = nvmlDeviceGetHandleByIndex(0)  # Solo se toma la GPU 0
uso = nvmlDeviceGetUtilizationRates(handle)

uso_cpu = psutil.cpu_percent(interval=1)
uso_memoria = psutil.virtual_memory().percent
uso_disco = psutil.disk_usage('/').percent
uso_gpu = uso.gpu

print(json.dumps({
    "uso_cpu": uso_cpu,
    "uso_memoria": uso_memoria,
    "uso_disco": uso_disco,
    "uso_gpu": uso.gpu
}))