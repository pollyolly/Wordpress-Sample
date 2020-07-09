<button title="Use this button to Report Video Error." class="btn-report"> Report </button>
       <div class="report-modal">
             <div class="report-modal-content">
                   <div class="report-modal-header">
                        <span>Report Error</span><span class="close">&times;</span>
                   </div>
                   <div class="report-modal-body">
                         <div class="report-body">
                            
                             <form id="report-form" action='#' method='post' >
    
                                <input type='text' id='title' name='title' maxlength='100' placeholder="Title" required/>
                                
                                <textarea id='description' name='description' maxlength='300' placeholder="Error Description" ></textarea>
                                
                                <button type='submit' class='btn btn-submit-error'> Submit </button>
                                
                            </form>
                                <div class="report-loader"></div>
                                <div class="report-response"></div>
                         </div>

                   </div>
             </div>
       </div>
