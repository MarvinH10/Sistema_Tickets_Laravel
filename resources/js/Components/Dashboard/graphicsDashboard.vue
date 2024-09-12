<template>
  <div class="dashboard-container grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 p-4 m-4">
    <div class="bg-green-400 shadow-lg p-4 rounded-lg chart-container">
      <div class="flex flex-col items-center justify-center h-full">
        <i class="fas fa-ticket-alt text-white text-2xl mb-1"></i>
        <h2 class="text-xl text-white font-bold mb-1">Asignados</h2>
        <div class="number-display text-white text-3xl font-bold">120</div>
      </div>
    </div>
    <div class="bg-yellow-400 shadow-lg p-4 rounded-lg chart-container">
      <div class="flex flex-col items-center justify-center h-full">
        <i class="fas fa-hourglass-half text-white text-2xl mb-1"></i>
        <h2 class="text-xl text-white font-bold mb-1">Pendientes</h2>
        <div class="number-display text-white text-3xl font-bold">45</div>
      </div>
    </div>
    <div class="bg-blue-400 shadow-lg p-4 rounded-lg chart-container">
      <div class="flex flex-col items-center justify-center h-full">
        <i class="fas fa-spinner text-white text-2xl mb-1"></i>
        <h2 class="text-xl text-white font-bold mb-1">En Progreso</h2>
        <div class="number-display text-white text-3xl font-bold">30</div>
      </div>
    </div>
    
    <div class="bg-red-400 shadow-lg p-4 rounded-lg chart-container">
      <div class="flex flex-col items-center justify-center h-full">
        <i class="fas fa-exclamation-triangle text-white text-2xl mb-1"></i>
        <h2 class="text-xl text-white font-bold mb-1">Urgentes</h2>
        <div class="number-display text-white text-3xl font-bold">10</div>
      </div>
    </div>
    <div class="bg-purple-400 shadow-lg p-4 rounded-lg chart-container">
      <div class="flex flex-col items-center justify-center h-full">
        <i class="fas fa-calendar-day text-white text-2xl mb-1"></i>
        <h2 class="text-xl text-white font-bold mb-1">Hoy</h2>
        <div class="number-display text-white text-3xl font-bold">20</div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.dashboard-container {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 1rem;
}

.chart-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  text-align: center;
  padding: 1rem; /* Ajusta el padding para hacer las tarjetas más pequeñas */
}

.number-display {
  margin-top: 0.5rem; /* Ajusta el espacio entre el título y el número */
}
</style>
