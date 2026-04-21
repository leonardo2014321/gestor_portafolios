<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario - Sistema de Portafolios</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Manrope:wght@800&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        manrope: ['Manrope', 'sans-serif'],
                    },
                },
            },
        }
    </script>

    <style>
        .animate-fade-in { animation: fadeIn 0.3s ease-out; }
        @keyframes fadeIn { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }
    </style>
</head>
<body class="bg-gray-200 min-h-screen font-sans">

    <div class="p-10 flex gap-10">
        
        <div class="flex-1 bg-white p-8 rounded-[30px] shadow-sm">
            <h2 class="text-2xl font-bold text-slate-800">Sistema de Portafolios</h2>
            <p class="text-slate-500">Haz clic en una fecha del calendario a la derecha para ver eventos.</p>
        </div>

        <div class="w-80 bg-white p-6 rounded-[30px] shadow-sm">
            <div class="flex justify-between items-center mb-6">
                <h3 class="font-manrope font-extrabold text-xl">Abril 2026</h3>
            </div>
            
            <div class="grid grid-cols-7 gap-2 text-center text-sm font-semibold text-slate-600">
                <div>Do</div><div>Lu</div><div>Ma</div><div>Mi</div><div>Ju</div><div>Vi</div><div>Sa</div>
                
                <button onclick="openDayModal('2026-04-09')" class="p-2 hover:bg-blue-50 rounded-lg">9</button>
                <button onclick="openDayModal('2026-04-10')" class="p-2 bg-blue-600 text-white rounded-lg relative">
                    10
                    <span class="absolute top-1 right-1 w-1.5 h-1.5 bg-green-400 rounded-full"></span>
                </button>
                <button onclick="openDayModal('2026-04-11')" class="p-2 hover:bg-blue-50 rounded-lg">11</button>
            </div>
        </div>
    </div>

    <div id="modal-container" class="fixed inset-0 bg-black/40 hidden z-50 flex items-center justify-center backdrop-blur-sm">
        
        <div class="w-[448px] bg-white rounded-[40px] shadow-[0px_50px_100px_-20px_#00000040] overflow-hidden animate-fade-in relative">

            <div class="flex items-start justify-between pt-8 px-8">
                <div>
                    <p class="text-[10px] text-slate-400 tracking-[2.40px] font-semibold uppercase">
                        Detalle del día
                    </p>
                    <h1 id="modal-date-title" class="text-3xl font-extrabold text-[#171c1f] font-manrope">
                        10 de Abril, 2026
                    </h1>
                </div>

                <button onclick="closeEventModal()" class="w-10 h-10 flex items-center justify-center rounded-full text-slate-400 hover:bg-slate-100 transition-colors">
                    ✕
                </button>
            </div>

            <div id="events-display" class="flex flex-col gap-5 pt-6 pb-8 px-8 max-h-[400px] overflow-y-auto">
                </div>

            <div class="flex gap-4 px-8 pb-8">
                <button onclick="closeEventModal()" class="w-[158px] py-4 rounded-2xl border border-[#c3c5d8] font-semibold text-[#171c1f] hover:bg-gray-50 transition-colors">
                    Cerrar
                </button>

                <button class="w-[210px] py-4 bg-[#0049db] text-white rounded-2xl font-semibold shadow-[0px_8px_10px_-6px_#0049db33] hover:bg-blue-700 transition-all flex items-center justify-center gap-2">
                    <span class="text-lg">+</span> Agregar Evento
                </button>
            </div>

        </div>
    </div>

    <script>
        [cite_start]// 1. SIMULACIÓN DE DATOS (Sin Base de Datos) [cite: 58, 69]
        const eventsData = {
            "2026-04-10": [
                { 
                    title: "Reunión de Proyecto integración", 
                    time: "10:00 AM - 11:30 AM", 
                    priority: "PRIORIDAD", 
                    type: "reunion" 
                },
                { 
                    title: "Entrega de Informe Mensual", 
                    time: "03:00 PM", 
                    priority: null, 
                    type: "entrega" 
                }
            ],
            // Puedes añadir más fechas aquí para probar
            "2026-04-09": [] 
        };

        /**
         * Abre el modal y llena la información según la fecha seleccionada [cite: 46, 61, 76]
         */
        function openDayModal(dateString) {
            const modal = document.getElementById('modal-container');
            const display = document.getElementById('events-display');
            const titleElement = document.getElementById('modal-date-title');
            
            // Formatear fecha para el título (ej: 10 de Abril, 2026) [cite: 46]
            const dateObj = new Date(dateString + 'T00:00:00');
            const formattedDate = dateObj.toLocaleDateString('es-ES', { day: 'numeric', month: 'long', year: 'numeric' });
            titleElement.innerText = formattedDate;

            // Obtener eventos de la fecha o array vacío si no hay [cite: 56]
            const dayEvents = eventsData[dateString] || [];
            display.innerHTML = ''; 

            if (dayEvents.length === 0) {
                // ESTADO: ESPACIO LIBRE [cite: 49]
                display.innerHTML = `
                    <div class="flex flex-col items-center justify-center p-5 border-2 border-dashed border-[#c3c5d84c] rounded-3xl group cursor-pointer hover:bg-slate-50 transition-colors">
                        <div class="text-xl text-slate-300 group-hover:text-blue-500">＋</div>
                        <span class="text-xs text-slate-400 tracking-[1px] font-semibold">ESPACIO LIBRE</span>
                    </div>`;
            } else {
                // RENDERIZAR CADA EVENTO [cite: 48, 71]
                dayEvents.forEach(ev => {
                    const isReunion = ev.type === 'reunion';
                    const colorBorder = isReunion ? 'border-[#0049db]' : 'border-[#006459]';
                    const bgIcon = isReunion ? 'bg-[#0049db1a]' : 'bg-[#0064591a]';
                    const icon = isReunion ? '👥' : '✔';

                    display.innerHTML += `
                        <div class="flex gap-4 p-5 bg-[#f0f4f8] rounded-3xl border-l-4 ${colorBorder} animate-fade-in">
                            <div class="w-10 h-10 flex items-center justify-center ${bgIcon} rounded-2xl shrink-0">
                                ${icon}
                            </div>
                            <div class="flex flex-col gap-2 flex-1">
                                <div class="flex justify-between items-start">
                                    <div class="text-base font-semibold text-[#171c1f] leading-5">
                                        ${ev.title.replace('\n', '<br>')}
                                    </div>
                                    ${ev.priority ? `
                                        <span class="text-[10px] px-2 py-1 rounded-full bg-[#0049db1a] text-[#0049db] font-bold tracking-wider">
                                            ${ev.priority}
                                        </span>
                                    ` : `
                                        <span class="w-2 h-2 ${isReunion ? 'bg-[#0049db]' : 'bg-[#006459]'} rounded-full mt-2"></span>
                                    `}
                                </div>
                                <div class="flex items-center gap-2 text-xs text-slate-500 font-medium">
                                    🕒 ${ev.time}
                                </div>
                            </div>
                        </div>`;
                });
            }

            // Mostrar el modal quitando la clase hidden [cite: 56, 71]
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // Bloquear scroll de fondo
        }

        /**
         * Cierra la ventana emergente [cite: 70, 82]
         */
        function closeEventModal() {
            document.getElementById('modal-container').classList.add('hidden');
            document.body.style.overflow = 'auto'; // Restaurar scroll
        }

        // Cerrar modal al hacer clic fuera del cuadro blanco
        window.onclick = function(event) {
            const modal = document.getElementById('modal-container');
            if (event.target == modal) {
                closeEventModal();
            }
        }
    </script>

</body>
</html>