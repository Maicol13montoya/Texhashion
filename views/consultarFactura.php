<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Asistente de Comprobantes</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
 
  
  <style>
    :root {
      --primary-color: #4361ee;
      --secondary-color: #3f37c9;
      --accent-color: #4cc9f0;
      --light-color: #f8f9fa;
      --dark-color: #212529;
      --success-color: #4bb543;
      --error-color: #ff3333;
      --info-color: #17a2b8;
    }
    
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
      min-height: 100vh;
      margin: 0;
      padding: 20px;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    
    #contenedor {
      width: 100%;
      max-width: 900px;
      display: flex;
      flex-direction: column;
      gap: 20px;
    }
    
    .chat-container {
      background: white;
      border-radius: 15px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.1);
      overflow: hidden;
      display: flex;
      flex-direction: column;
      height: 600px;
    }
    
    .chat-header {
      background: var(--primary-color);
      color: white;
      padding: 15px 20px;
      display: flex;
      align-items: center;
      gap: 10px;
    }
    
    .chat-header i {
      font-size: 1.5rem;
    }
    
    .chat-messages {
      flex: 1;
      padding: 20px;
      overflow-y: auto;
      display: flex;
      flex-direction: column;
      gap: 15px;
    }
    
    .message {
      max-width: 80%;
      padding: 12px 15px;
      border-radius: 18px;
      line-height: 1.4;
      position: relative;
    }
    
    .bot-message {
      align-self: flex-start;
      background: #f1f1f1;
      color: var(--dark-color);
      border-bottom-left-radius: 5px;
    }
    
    .user-message {
      align-self: flex-end;
      background: var(--primary-color);
      color: white;
      border-bottom-right-radius: 5px;
    }
    
    .chat-input {
      display: flex;
      padding: 15px;
      background: #f8f9fa;
      border-top: 1px solid #eee;
    }
    
    .chat-input input {
      flex: 1;
      padding: 12px 15px;
      border: 1px solid #ddd;
      border-radius: 30px;
      outline: none;
      font-size: 1rem;
    }
    
    .chat-input button {
      margin-left: 10px;
      background: var(--primary-color);
      color: white;
      border: none;
      border-radius: 30px;
      padding: 0 20px;
      cursor: pointer;
      transition: all 0.3s;
    }
    
    .chat-input button:hover {
      background: var(--secondary-color);
    }
    
    .comprobante {
      background: white;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.1);
      display: none;
      position: relative;
    }
    
    .comprobante-header {
      text-align: center;
      margin-bottom: 30px;
    }
    
    .comprobante-header img {
      max-width: 180px;
      margin-bottom: 15px;
    }
    
    .comprobante-header h3 {
      color: var(--primary-color);
      margin: 0;
      font-size: 1.8rem;
    }
    
    .comprobante-body {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 15px;
    }
    
    .comprobante-item {
      margin-bottom: 10px;
    }
    
    .comprobante-item strong {
      display: block;
      color: var(--primary-color);
      margin-bottom: 5px;
    }
    
    .download-btn {
      display: block;
      width: 100%;
      padding: 12px;
      background: var(--primary-color);
      color: white;
      text-align: center;
      border-radius: 8px;
      text-decoration: none;
      margin-top: 25px;
      transition: all 0.3s;
      border: none;
      cursor: pointer;
      font-size: 1rem;
    }
    
    .download-btn:hover {
      background: var(--secondary-color);
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .error-message {
      color: var(--error-color);
      text-align: center;
      padding: 10px;
      background: #ffebee;
      border-radius: 8px;
      margin-top: 10px;
      display: none;
    }
    
    .typing-indicator {
      display: inline-block;
      padding: 10px 15px;
      background: #f1f1f1;
      border-radius: 18px;
      border-bottom-left-radius: 5px;
    }
    
    .typing-indicator span {
      height: 8px;
      width: 8px;
      background: #999;
      border-radius: 50%;
      display: inline-block;
      margin: 0 2px;
      animation: bounce 1.5s infinite ease-in-out;
    }
    
    .typing-indicator span:nth-child(2) {
      animation-delay: 0.2s;
    }
    
    .typing-indicator span:nth-child(3) {
      animation-delay: 0.4s;
    }
    
    @keyframes bounce {
      0%, 60%, 100% { transform: translateY(0); }
      30% { transform: translateY(-5px); }
    }
    
    .home-icon {
      position: fixed;
      top: 20px;
      left: 20px;
      z-index: 1000;
      width: 50px;
      height: 50px;
      background: white;
      border-radius: 50%;
      display: flex;
      justify-content: center;
      align-items: center;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
      transition: all 0.3s;
    }
    
    .home-icon:hover {
      transform: scale(1.1);
      background: var(--primary-color);
    }
    
    .home-icon a {
      color: var(--primary-color);
      font-size: 1.5rem;
      text-decoration: none;
    }
    
    .home-icon:hover a {
      color: white;
    }
    
    /* Estilos para los botones de opciones */
    .options-container {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      margin-top: 10px;
    }
    
    .option-btn {
      background: var(--accent-color);
      color: white;
      border: none;
      border-radius: 20px;
      padding: 8px 15px;
      cursor: pointer;
      transition: all 0.3s;
      font-size: 0.9rem;
    }
    
    .option-btn:hover {
      background: var(--secondary-color);
      transform: translateY(-2px);
    }
    
    .search-type-selector {
      display: flex;
      gap: 10px;
      margin-bottom: 10px;
      flex-wrap: wrap;
    }
    
    .search-type-btn {
      background: #e0e0e0;
      border: none;
      border-radius: 20px;
      padding: 8px 15px;
      cursor: pointer;
      transition: all 0.3s;
    }
    
    .search-type-btn.active {
      background: var(--primary-color);
      color: white;
    }
    
    .contact-info {
      background: var(--info-color);
      color: white;
      padding: 15px;
      border-radius: 10px;
      margin-top: 15px;
    }
    
    .contact-info h4 {
      margin-top: 0;
      margin-bottom: 10px;
    }
    
    .contact-info p {
      margin: 5px 0;
    }
    
    .contact-info a {
      color: white;
      text-decoration: underline;
    }
    
    .quick-actions {
      display: flex;
      gap: 10px;
      margin-top: 15px;
      flex-wrap: wrap;
    }
    
    .quick-action-btn {
      background: var(--primary-color);
      color: white;
      border: none;
      border-radius: 20px;
      padding: 8px 15px;
      cursor: pointer;
      transition: all 0.3s;
      font-size: 0.9rem;
    }
    
    .quick-action-btn:hover {
      background: var(--secondary-color);
    }
    
    @media (max-width: 768px) {
      .comprobante-body {
        grid-template-columns: 1fr;
      }
      
      .chat-container {
        height: 500px;
      }
      
      .options-container, .quick-actions {
        flex-direction: column;
      }
      
      .option-btn, .quick-action-btn {
        width: 100%;
      }
      
      .search-type-selector {
        flex-direction: column;
      }
    }
    
    /* Estilos específicos para el PDF */
    .pdf-container {
      width: 100%;
      padding: 20px;
      box-sizing: border-box;
      background: white;
      color: black;
    }
    
    .pdf-container img {
      max-width: 150px;
      height: auto;
      display: block;
      margin: 0 auto 20px;
    }
    
    .pdf-container h3 {
      color: #4361ee;
      text-align: center;
      margin-bottom: 20px;
    }
    
    .pdf-body {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 15px;
    }
    
    .pdf-item {
      margin-bottom: 10px;
    }
    
    .pdf-item strong {
      color: #4361ee;
      display: block;
      margin-bottom: 5px;
    }
  </style>
</head>
<body>
  <div class="home-icon">
    <a href="/TexFashion2/index.php">
      <i class="fas fa-home"></i>
    </a>
  </div>
  
  <div id="contenedor">
    <div class="chat-container">
      <div class="chat-header">
    <i class="fa-solid fa-headset"></i>
        <h2>Asistente de Comprobantes</h2>
      </div>
      <div class="chat-messages" id="chat-messages">
        <div class="message bot-message">
          ¡Hola! Puedo ayudarte a buscar comprobantes o proporcionarte información de contacto.
        </div>
      </div>
      <div class="chat-input">
        <input type="text" id="user-input" placeholder="Escribe tu consulta aquí..." autofocus>
        <button id="send-btn"><i class="fas fa-paper-plane"></i></button>
      </div>
    </div>
    
    <div class="comprobante" id="comprobante">
      <div class="comprobante-header">
        <img src="../assets/img/TexFashion.png" alt="TexFashion Logo">
        <h3>Comprobante de Pago</h3>
      </div>
      <div class="comprobante-body">
        <div class="comprobante-item">
          <strong>Número de Comprobante:</strong>
          <span id="numero"></span>
        </div>
        <div class="comprobante-item">
          <strong>Producto/Servicio:</strong>
          <span id="producto"></span>
        </div>
        <div class="comprobante-item">
          <strong>Cantidad:</strong>
          <span id="cantidad"></span>
        </div>
        <div class="comprobante-item">
          <strong>Precio Total:</strong>
          <span id="precio"></span>
        </div>
        <div class="comprobante-item">
          <strong>Fecha de Emisión:</strong>
          <span id="emision"></span>
        </div>
        <div class="comprobante-item">
          <strong>Fecha de Pago:</strong>
          <span id="pago"></span>
        </div>
        <div class="comprobante-item">
          <strong>Dirección:</strong>
          <span id="direccion"></span>
        </div>
        <div class="comprobante-item">
          <strong>Estado:</strong>
          <span id="estado"></span>
        </div>
        <div class="comprobante-item">
          <strong>Referencia de Pago:</strong>
          <span id="referenciaPago"></span>
        </div>
      </div>
      <button class="download-btn" id="download-btn">
        <i class="fas fa-file-pdf"></i> Descargar Comprobante en PDF
      </button>
    </div>
    
    <div class="error-message" id="error-message"></div>
  </div>

  <script>
    $(document).ready(function() {
      // Configuración inicial
      const chatMessages = $('#chat-messages');
      const userInput = $('#user-input');
      const sendBtn = $('#send-btn');
      const comprobante = $('#comprobante');
      const errorMessage = $('#error-message');
      let currentSearchType = 'numero'; // 'numero', 'referencia' o 'correo'
      
      // Información de contacto del establecimiento
      const contactoEstablecimiento = {
        nombre: "TexFashion",
        correos: ["info@texfashion.com", "ventas@texfashion.com", "soporte@texfashion.com"],
        telefonos: ["314534211", "3214911633"],
        horarios: "Lunes a Viernes: 9:00 AM - 7:00 PM\nSábados: 9:00 AM - 2:00 PM",
        direccion: "Av. 14 cra 15 sur , Bogota, Colombia"
      };
      
      // Función para agregar mensajes al chat
      function addMessage(message, isUser = false) {
        const messageClass = isUser ? 'user-message' : 'bot-message';
        chatMessages.append(`<div class="message ${messageClass}">${message}</div>`);
        chatMessages.scrollTop(chatMessages[0].scrollHeight);
      }
      
      // Función para mostrar que el bot está escribiendo
      function showTyping() {
        const typingElement = $(`
          <div class="message bot-message typing-indicator">
            <span></span>
            <span></span>
            <span></span>
          </div>
        `);
        chatMessages.append(typingElement);
        chatMessages.scrollTop(chatMessages[0].scrollHeight);
        return typingElement;
      }
      
      // Función para mostrar opciones de búsqueda
      function showSearchOptions() {
        const optionsElement = $(`
          <di class="message bot-message">
            <p>¿Cómo deseas buscar el comprobante?</p>
            <div class="search-type-selector">
             
              <button class="search-type-btn ${currentSearchType === 'referencia' ? 'active' : ''}" id="search-by-reference">Por referencia</button>
              
            </div>
          
          
             
          
            
            <div class="quick-actions">
              <button class="quick-action-btn" id="show-contact-btn">
                <i class="fas fa-phone-alt"></i> Contacto
              </button>
              <button class="quick-action-btn" id="show-hours-btn">
                <i class="fas fa-clock"></i> Horarios
              </button>
              <button class="quick-action-btn" id="show-emails-btn">
                <i class="fas fa-envelope"></i> Correos
              </button>
            </div>
          </div>
        `);
        
        chatMessages.append(optionsElement);
        chatMessages.scrollTop(chatMessages[0].scrollHeight);
        
        // Eventos para los botones de opciones
        $('.option-btn').click(function() {
          const value = $(this).data('value');
          if (value === 'contacto') {
            showContactInfo();
          } else {
            userInput.val(value);
            sendBtn.click();
          }
        });
        
        // Eventos para los botones de tipo de búsqueda
        $('#search-by-number').click(function() {
          currentSearchType = 'numero';
          $(this).addClass('active');
          $('#search-by-reference').removeClass('active');
          $('#search-by-email').removeClass('active');
          userInput.attr('placeholder', 'Escribe el número de comprobante...');
        });
        
        $('#search-by-reference').click(function() {
          currentSearchType = 'referencia';
          $(this).addClass('active');
          $('#search-by-number').removeClass('active');
          $('#search-by-email').removeClass('active');
          userInput.attr('placeholder', 'Escribe la referencia de pago...');
        });
        
        $('#search-by-email').click(function() {
          currentSearchType = 'correo';
          $(this).addClass('active');
          $('#search-by-number').removeClass('active');
          $('#search-by-reference').removeClass('active');
          userInput.attr('placeholder', 'Escribe el correo electrónico...');
        });
        
        // Eventos para acciones rápidas
        $('#show-contact-btn').click(showContactInfo);
        $('#show-hours-btn').click(showBusinessHours);
        $('#show-emails-btn').click(showEmailAddresses);
      }
      
      // Función para mostrar información de contacto
      function showContactInfo() {
        const typingElement = showTyping();
        
        setTimeout(() => {
          typingElement.remove();
          
          const contactInfo = `
            <div class="contact-info">
              <h4><i class="fas fa-store"></i> ${contactoEstablecimiento.nombre}</h4>
              <p><i class="fas fa-map-marker-alt"></i> ${contactoEstablecimiento.direccion}</p>
              <p><i class="fas fa-phone"></i> Teléfonos: ${contactoEstablecimiento.telefonos.join(', ')}</p>
              <p><i class="fas fa-envelope"></i> Correos principales: ${contactoEstablecimiento.correos.slice(0, 2).join(', ')}</p>
              <p><i class="fas fa-clock"></i> ${contactoEstablecimiento.horarios.replace('\n', '<br>')}</p>
            </div>
          `;
          
          addMessage(`Aquí tienes la información de contacto de ${contactoEstablecimiento.nombre}:`);
          chatMessages.append(contactInfo);
          chatMessages.scrollTop(chatMessages[0].scrollHeight);
        }, 1000);
      }
      
      // Función para mostrar horarios de atención
      function showBusinessHours() {
        const typingElement = showTyping();
        
        setTimeout(() => {
          typingElement.remove();
          
          const hoursInfo = `
            <div class="contact-info">
              <h4><i class="fas fa-clock"></i> Horarios de Atención</h4>
              <p>${contactoEstablecimiento.horarios.replace('\n', '<br>')}</p>
              <p><i class="fas fa-info-circle"></i> Cerramos los domingos y días feriados</p>
            </div>
          `;
          
          addMessage("Estos son nuestros horarios de atención:");
          chatMessages.append(hoursInfo);
          chatMessages.scrollTop(chatMessages[0].scrollHeight);
        }, 1000);
      }
      
      // Función para mostrar correos electrónicos
      function showEmailAddresses() {
        const typingElement = showTyping();
        
        setTimeout(() => {
          typingElement.remove();
          
          const emailsList = contactoEstablecimiento.correos.map(email => 
            `<p><i class="fas fa-envelope"></i> <a href="mailto:${email}">${email}</a></p>`
          ).join('');
          
          const emailsInfo = `
            <div class="contact-info">
              <h4><i class="fas fa-at"></i> Correos Electrónicos</h4>
              ${emailsList}
              <p><i class="fas fa-info-circle"></i> Para consultas generales: ${contactoEstablecimiento.correos[0]}</p>
            </div>
          `;
          
          addMessage("Estos son nuestros correos electrónicos de contacto:");
          chatMessages.append(emailsInfo);
          chatMessages.scrollTop(chatMessages[0].scrollHeight);
        }, 1000);
      }
      
      // Función para buscar comprobante
      function buscarComprobante(valor) {
        // Mostrar indicador de que el bot está escribiendo
        const typingElement = showTyping();
        
        // Ocultar comprobante y mensajes de error previos
        comprobante.hide();
        errorMessage.hide();
        
        // Validar entrada
        if (!valor) {
          setTimeout(() => {
            typingElement.remove();
            addMessage("Por favor, ingresa un valor válido para la búsqueda.");
          }, 1000);
          return;
        }
        
        // Determinar el tipo de búsqueda
        const tipoBusqueda = currentSearchType;
        
        // Si el usuario busca información de contacto
        if (valor.toLowerCase().includes('contacto') || 
            valor.toLowerCase().includes('correo') || 
            valor.toLowerCase().includes('teléfono') || 
            valor.toLowerCase().includes('horario')) {
          setTimeout(() => {
            typingElement.remove();
            if (valor.toLowerCase().includes('correo')) {
              showEmailAddresses();
            } else if (valor.toLowerCase().includes('horario')) {
              showBusinessHours();
            } else {
              showContactInfo();
            }
          }, 1000);
          return;
        }
        
        // Realizar la consulta AJAX
        $.ajax({
          url: './consulta_factura.php',
          method: 'GET',
          data: { 
            [tipoBusqueda]: valor,
            tipo_busqueda: tipoBusqueda
          },
          dataType: 'json',
          success: function(res) {
            setTimeout(() => {
              typingElement.remove();
              
              if (res.Numero_Factura) {
                // Mostrar datos del comprobante
                $('#numero').text(res.Numero_Factura);
                $('#producto').text(res.Producto);
                $('#cantidad').text(res.Cantidad);
                $('#precio').text(`$${parseFloat(res.Precio_Total).toFixed(2)}`);
                $('#emision').text(res.Fecha_Emision);
                $('#pago').text(res.Fecha_Pago);
                $('#direccion').text(res.Direccion);
                $('#estado').text(res.Estado);
                $('#referenciaPago').text(res.Referencia_Pago);
                
                comprobante.fadeIn();
                addMessage(`He encontrado el comprobante #${res.Numero_Factura}. Aquí tienes los detalles:`);
                
                // Hacer scroll hasta el comprobante
                $('html, body').animate({
                  scrollTop: comprobante.offset().top - 20
                }, 500);
              } else if (res.response || res.error) {
                const errorMsg = res.response || res.error;
                errorMessage.text(errorMsg).fadeIn();
                addMessage("Lo siento, no he podido encontrar ese comprobante. Por favor verifica los datos e intenta nuevamente.");
              } else {
                errorMessage.text("Respuesta desconocida del servidor").fadeIn();
                addMessage("Ha ocurrido un error inesperado. Por favor intenta más tarde.");
              }
            }, 1500);
          },
          error: function(xhr) {
            setTimeout(() => {
              typingElement.remove();
              errorMessage.text("Error al conectar con el servidor").fadeIn();
              addMessage("Estoy teniendo problemas para conectarme con el servidor. Por favor intenta más tarde.");
              console.error("AJAX Error:", xhr.responseText);
            }, 1500);
          }
        });
      }
      
      // Función para descargar PDF
      function descargarPDF() {
        // Crear un clon del comprobante para el PDF
        const original = document.getElementById('comprobante');
        const clone = original.cloneNode(true);
        clone.id = 'comprobante-pdf';
        clone.className = 'pdf-container';
        
        // Modificar el clon para el PDF
        $(clone).find('.comprobante-header').remove();
        $(clone).find('.download-btn').remove();
        
        // Crear encabezado para el PDF
        const pdfHeader = document.createElement('div');
        pdfHeader.className = 'pdf-header';
        pdfHeader.innerHTML = `
          <img src="../assets/img/TexFashion.png" alt="TexFashion Logo">
          <h3>Comprobante de Pago</h3>
        `;
        clone.insertBefore(pdfHeader, clone.firstChild);
        
        // Añadir estilos específicos para el PDF
        const style = document.createElement('style');
        style.innerHTML = `
          .pdf-container {
            font-family: Arial, sans-serif;
            width: 100%;
            padding: 20px;
            box-sizing: border-box;
          }
          .pdf-header {
            text-align: center;
            margin-bottom: 20px;
          }
          .pdf-header img {
            max-width: 150px;
            height: auto;
          }
          .pdf-body {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
          }
          .pdf-item {
            margin-bottom: 10px;
          }
          .pdf-item strong {
            color: #4361ee;
            display: block;
            margin-bottom: 5px;
          }
        `;
        clone.appendChild(style);
        
        // Crear un elemento oculto para renderizar
        const hiddenDiv = document.createElement('div');
        hiddenDiv.style.position = 'absolute';
        hiddenDiv.style.left = '-9999px';
        hiddenDiv.appendChild(clone);
        document.body.appendChild(hiddenDiv);
        
        const comprobanteNum = document.getElementById("numero").innerText || 'cliente';
        
        // Configuración de html2pdf
        const opciones = {
          margin: 10,
          filename: `Comprobante_${comprobanteNum}.pdf`,
          image: { 
            type: 'jpeg', 
            quality: 0.98 
          },
          html2canvas: { 
            scale: 2,
            logging: true,
            useCORS: true,
            scrollX: 0,
            scrollY: 0,
            windowWidth: document.documentElement.offsetWidth
          },
          jsPDF: { 
            unit: 'mm', 
            format: 'a4', 
            orientation: 'portrait' 
          }
        };
        
        addMessage("Generando tu comprobante en PDF...");
        
        // Generar PDF después de un pequeño retraso para asegurar la renderización
        setTimeout(() => {
          html2pdf()
            .set(opciones)
            .from(clone)
            .save()
            .then(() => {
              addMessage("¡Comprobante descargado con éxito! ¿Necesitas algo más?");
              document.body.removeChild(hiddenDiv);
            })
            .catch(err => {
              console.error("Error al generar PDF:", err);
              addMessage("Hubo un problema al generar el PDF. Por favor intenta nuevamente.");
              document.body.removeChild(hiddenDiv);
            });
        }, 500);
      }
      
      // Evento al hacer clic en el botón enviar
      sendBtn.click(function() {
        const message = userInput.val().trim();
        if (message) {
          addMessage(message, true);
          userInput.val('');
          buscarComprobante(message);
        }
      });
      
      // Evento al presionar Enter en el input
      userInput.keypress(function(e) {
        if (e.which === 13) {
          sendBtn.click();
        }
      });
      
      // Evento para el botón de descarga
      $('#download-btn').click(descargarPDF);
      
      // Mensaje inicial del bot con opciones
      setTimeout(() => {
        addMessage("¿En qué puedo ayudarte hoy? Puedes buscar un comprobante o consultar nuestra información de contacto:");
        showSearchOptions();
      }, 1500);
    });
  </script>
</body>
</html>