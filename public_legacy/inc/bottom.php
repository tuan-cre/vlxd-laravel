            </div>
        </section>
        
        <!-- Features Section -->
        <section class="py-5 bg-light">
            <div class="container-fluid px-4">
                <div class="row g-4">
                    <div class="col-md-3 text-center">
                        <div class="p-4 bg-white rounded-3 shadow-sm h-100">
                            <i class="bi bi-truck fs-1 text-primary mb-3"></i>
                            <h5 class="fw-bold">Miễn Phí Vận Chuyển</h5>
                            <p class="text-muted small mb-0">Đơn hàng từ 5 triệu trở lên</p>
                        </div>
                    </div>
                    <div class="col-md-3 text-center">
                        <div class="p-4 bg-white rounded-3 shadow-sm h-100">
                            <i class="bi bi-shield-check fs-1 text-success mb-3"></i>
                            <h5 class="fw-bold">Chất Lượng Đảm Bảo</h5>
                            <p class="text-muted small mb-0">100% hàng chính hãng</p>
                        </div>
                    </div>
                    <div class="col-md-3 text-center">
                        <div class="p-4 bg-white rounded-3 shadow-sm h-100">
                            <i class="bi bi-headset fs-1 text-info mb-3"></i>
                            <h5 class="fw-bold">Hỗ Trợ 24/7</h5>
                            <p class="text-muted small mb-0">Tư vấn nhiệt tình</p>
                        </div>
                    </div>
                    <div class="col-md-3 text-center">
                        <div class="p-4 bg-white rounded-3 shadow-sm h-100">
                            <i class="bi bi-arrow-repeat fs-1 text-warning mb-3"></i>
                            <h5 class="fw-bold">Đổi Trả Dễ Dàng</h5>
                            <p class="text-muted small mb-0">Trong vòng 7 ngày</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Footer Modern -->
    <footer class="py-5" style="background: linear-gradient(135deg, rgba(var(--primary-rgb),0.95) 0%, rgba(var(--primary-strong-rgb),0.95) 100%); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); position: relative; overflow: hidden;">
            <div class="container-fluid px-4">
                <div class="row text-light g-4">
                    <div class="col-lg-4 col-md-6">
                        <?php if(!isset($site_info)) { require_once(__DIR__ . '/../../model/site_info.php'); $site_info = (new SITE_INFO())->getSiteInfo(); } ?>
                        <h4 class="fw-bold mb-4"><i class="bi bi-building"></i> <?php echo htmlspecialchars($site_info['site_name'] ?? 'VLXD Di Hiền'); ?></h4>
                        <p class="mb-3"><?php echo htmlspecialchars($site_info['about'] ?? 'Đối tác tin cậy trong xây dựng. Cung cấp vật liệu xây dựng chất lượng cao với giá cả cạnh tranh nhất thị trường.'); ?></p>
                        <div class="d-flex flex-column gap-2 mb-3">
                            <div><i class="bi bi-geo-alt-fill me-2"></i> <?php echo htmlspecialchars($site_info['address'] ?? '18 Ung Văn Khiêm, TP Long Xuyên, An Giang'); ?></div>
                            <div><i class="bi bi-telephone-fill me-2"></i> Hotline: <strong><?php echo htmlspecialchars($site_info['hotline'] ?? '0333666999'); ?></strong></div>
                            <div><i class="bi bi-envelope-fill me-2"></i> <?php echo htmlspecialchars($site_info['email'] ?? 'lhtuan7924@gmail.com'); ?></div>
                            <div><i class="bi bi-clock-fill me-2"></i> 7:00 - 18:00 (Thứ 2 - Chủ nhật)</div>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="#" class="btn btn-light btn-sm rounded-circle" style="width:40px;height:40px;padding:8px;"><i class="bi bi-facebook fs-5"></i></a>
                            <a href="#" class="btn btn-light btn-sm rounded-circle" style="width:40px;height:40px;padding:8px;"><i class="bi bi-youtube fs-5"></i></a>
                            <a href="#" class="btn btn-light btn-sm rounded-circle" style="width:40px;height:40px;padding:8px;"><i class="bi bi-telephone fs-5"></i></a>
                            <a href="#" class="btn btn-light btn-sm rounded-circle" style="width:40px;height:40px;padding:8px;"><i class="bi bi-envelope fs-5"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <h5 class="fw-bold mb-4">DANH MỤC</h5>
                        <div class="d-flex flex-column gap-2">
                            <?php foreach ($danhmuc as $d): ?>
                                <a class="text-light text-decoration-none d-flex align-items-center footer-link" href="?action=group&id=<?php echo $d["id"]; ?>">
                                    <i class="bi bi-arrow-right-short me-1"></i> <?php echo $d["name"]; ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <h5 class="fw-bold mb-4">VỀ CHÚNG TÔI</h5>
                        <div class="d-flex flex-column gap-2">
                            <a href="index.php?action=gioithieu" class="text-light text-decoration-none footer-link"><i class="bi bi-arrow-right-short me-1"></i> Giới thiệu</a>
                            <a href="index.php?action=danhsachtintuc" class="text-light text-decoration-none footer-link"><i class="bi bi-arrow-right-short me-1"></i> Tin tức</a>
                            <a href="#" class="text-light text-decoration-none footer-link"><i class="bi bi-arrow-right-short me-1"></i> Tuyển dụng</a>
                            <a href="index.php?action=lienhe" class="text-light text-decoration-none footer-link"><i class="bi bi-arrow-right-short me-1"></i> Liên hệ</a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <h5 class="fw-bold mb-4">HỖ TRỢ</h5>
                        <div class="d-flex flex-column gap-2">
                            <a href="#" class="text-light text-decoration-none footer-link"><i class="bi bi-arrow-right-short me-1"></i> Chính sách bảo hành</a>
                            <a href="#" class="text-light text-decoration-none footer-link"><i class="bi bi-arrow-right-short me-1"></i> Chính sách vận chuyển</a>
                            <a href="#" class="text-light text-decoration-none footer-link"><i class="bi bi-arrow-right-short me-1"></i> Hướng dẫn đặt hàng</a>
                            <a href="#" class="text-light text-decoration-none footer-link"><i class="bi bi-arrow-right-short me-1"></i> Phương thức thanh toán</a>
                            <a href="#" class="text-light text-decoration-none footer-link"><i class="bi bi-arrow-right-short me-1"></i> Câu hỏi thường gặp</a>
                        </div>
                    </div>
                </div>
                
                <hr class="my-4 bg-light opacity-25">
                
                <div class="row align-items-center">
                    <div class="col-md-6 text-center text-md-start">
                        <p class="mb-0 text-light"><?php echo htmlspecialchars($site_info['footer_text'] ?? '© 2025 VLXD Di Hiền. All rights reserved.'); ?></p>
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <a href="#top" class="btn btn-light btn-sm rounded-circle" style="width:45px;height:45px;padding:10px;">
                            <i class="bi bi-arrow-up fs-5"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Footer Background Overlay (simplified to avoid inline SVG encoding issues) -->
            <div style="position: absolute; inset: 0; background: linear-gradient(90deg, rgba(255,255,255,0.02), rgba(255,255,255,0.0)); opacity: 0.25; pointer-events: none;"></div>
        </footer>

        <!-- Floating Chat Widget -->
        <div id="chat-widget" aria-live="polite">
            <button id="chat-toggle" class="btn btn-primary rounded-circle" title="Chat với chúng tôi" style="position:fixed;right:20px;bottom:20px;width:56px;height:56px;z-index:1100;display:flex;align-items:center;justify-content:center;">
                <i class="bi bi-chat-dots-fill" style="font-size:1.25rem;color:#fff"></i>
            </button>

            <div id="chat-box" style="display:none;position:fixed;right:20px;bottom:86px;width:360px;max-width:92vw;z-index:1100;background:#fff;border-radius:12px;box-shadow:0 10px 30px rgba(0,0,0,0.15);overflow:hidden;">
                <div style="background:#0d6efd;color:#fff;padding:12px 14px;display:flex;align-items:center;justify-content:space-between;">
                    <div style="font-weight:600">Hỗ trợ trực tuyến</div>
                    <button id="chat-close" class="btn btn-sm btn-light" style="opacity:0.9">Đóng</button>
                </div>
            <div id="chat-messages" style="height:320px;overflow:auto;padding:12px;background:#f8f9fa;display:flex;flex-direction:column;gap:12px;">
                <div class="chat-system" style="font-size:0.9rem;color:#666">Xin chào! Tôi có thể giúp gì cho bạn hôm nay?</div>
                </div>
                <form id="chat-form" style="display:flex;gap:8px;padding:10px;border-top:1px solid #eee;background:#fff">
                    <input id="chat-input" type="text" placeholder="Nhập tin nhắn..." aria-label="Tin nhắn" style="flex:1;border:1px solid #ddd;border-radius:8px;padding:8px 10px;">
                    <button type="submit" class="btn btn-primary" style="padding:8px 12px;border-radius:8px">Gửi</button>
                </form>
            </div>
        </div>

        <script>
        (function(){
            const toggle = document.getElementById('chat-toggle');
            const box = document.getElementById('chat-box');
            const closeBtn = document.getElementById('chat-close');
            const form = document.getElementById('chat-form');
            const input = document.getElementById('chat-input');
            const messages = document.getElementById('chat-messages');

            function openChat(){ box.style.display = 'block'; input.focus(); }
            function closeChat(){ box.style.display = 'none'; }

            toggle.addEventListener('click', ()=>{
                if(box.style.display === 'none' || box.style.display === '') openChat(); else closeChat();
            });
            closeBtn.addEventListener('click', closeChat);

            function appendMessage(text, who, meta){
                const wrapper = document.createElement('div');
                wrapper.className = 'chat-msg d-flex align-items-start';
                wrapper.style.maxWidth = '100%';
                
                const bubble = document.createElement('div');
                bubble.style.padding = '8px 12px';
                bubble.style.borderRadius = '12px';
                bubble.style.maxWidth = '84%';
                bubble.style.lineHeight = '1.35';
                
                const time = document.createElement('div');
                time.style.fontSize = '0.75rem';
                time.style.opacity = '0.7';
                time.style.marginTop = '6px';
                time.textContent = new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});

                if(who === 'user'){
                    wrapper.style.justifyContent = 'flex-end';
                    bubble.style.background = '#0d6efd';
                    bubble.style.color = '#fff';
                    wrapper.appendChild(bubble);
                } else { // bot
                    wrapper.style.justifyContent = 'flex-start';
                    bubble.style.background = '#fff';
                    bubble.style.border = '1px solid #eee';
                    bubble.style.color = '#333';
                    // Bot Avatar
                    const avatar = document.createElement('div');
                    avatar.style.width = '32px'; avatar.style.height = '32px';
                    avatar.style.borderRadius = '50%';
                    avatar.style.background = '#6c757d';
                    avatar.style.color = '#fff';
                    avatar.style.display = 'flex'; avatar.style.alignItems = 'center'; avatar.style.justifyContent = 'center';
                    avatar.style.marginRight = '8px';
                    avatar.innerHTML = '<i class="bi bi-robot"></i>';
                    wrapper.appendChild(avatar);
                    wrapper.appendChild(bubble);
                }
                
                // Add content
                const inner = document.createElement('div');
                inner.textContent = text;
                bubble.appendChild(inner);
                bubble.appendChild(time);
                
                messages.appendChild(wrapper);
                messages.scrollTop = messages.scrollHeight;
            }

            function appendTyping(){
                const el = document.createElement('div');
                el.className = 'typing-indicator';
                el.style.alignSelf = 'flex-start';
                el.style.color = '#888';
                el.style.fontSize = '0.8rem';
                el.style.padding = '5px 10px';
                el.style.fontStyle = 'italic';
                el.textContent = 'Đang trả lời...';
                messages.appendChild(el);
                messages.scrollTop = messages.scrollHeight;
                return el;
            }

            form.addEventListener('submit', function(e){
                e.preventDefault();
                const text = input.value.trim();
                if(!text) return;
                
                // 1. Show User Message
                appendMessage(text, 'user');
                input.value = '';
                const typingEl = appendTyping();

                // 2. Prepare Payload
                const conv = localStorage.getItem('coze_conv_id');
                const uid = localStorage.getItem('coze_user_id');
                const body = { message: text };
                
                if (conv) body.conversation_id = conv;
                if (uid) body.user_id = uid;

                // 3. Call PHP Backend
                fetch('/api/chatbot.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(body)
                })
                .then(r => r.json())
                .then(data => {
                    typingEl.remove(); // Remove typing indicator

                    if(data.error){
                        appendMessage('Lỗi: ' + (data.msg || data.error), 'bot');
                    } else if (data.reply) {
                        // --- SUCCESS: Display just the reply text ---
                        appendMessage(data.reply, 'bot');
                        
                        // Save IDs for next time
                        if (data.conversation_id) localStorage.setItem('coze_conv_id', data.conversation_id);
                        if (data.user_id) localStorage.setItem('coze_user_id', data.user_id);
                    } else {
                        appendMessage("Không nhận được phản hồi.", 'bot');
                    }
                })
                .catch(err => {
                    typingEl.remove();
                    appendMessage('Lỗi kết nối server.', 'bot');
                    console.error(err);
                });
            });
        })();
        </script>

    </body>
</html>

