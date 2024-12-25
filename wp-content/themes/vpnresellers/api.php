<?php
/*
Template Name: Api
*/
?>

<?php get_header(); ?>
<div class="container">
  <div class="page-left-side-page">
    <div class="--left">
    <?php get_sidebar("api"); ?>

    </div>
    <div class="--right --small">
      <div class="breadcrumbs">
        <!-- <div class="breadcrumbs">
          <div class="container">
            <ul class="breadcrumbs__items" itemscope="" itemtype="https://schema.org/BreadcrumbList">
              <li class="breadcrumbs__item" itemprop="itemListElement" itemscope=""
                itemtype="https://schema.org/ListItem">
                <a href="https://smsbower.net/" itemprop="item">
                  <span itemprop="name">Главная</span>
                </a>
                <meta itemprop="position" content="1">
                <meta itemprop="item" content="https://smsbower.net">
              </li>
              <li class="breadcrumbs__item" itemprop="itemListElement" itemscope=""
                itemtype="https://schema.org/ListItem">
                <span itemprop="name">Временные почты</span>
                <meta itemprop="position" content="2">
                <meta itemprop="item" content="">
              </li>
            </ul>
          </div>
        </div> -->

      </div>

      <div class="cms-block-stab">
      <?php if(have_posts()) : while(have_posts()) : the_post(); ?>
        <h1 itemprop="title"><?php the_title() ?></h1>
        <?php the_content(); ?>
        <?php endwhile; ?>
      <?php endif; ?>

      </div>
    </div>
  </div>
  <div class="form-wrapper" itemscope="" itemtype="http://schema.org/WebPage">
    <div id="vue-notification-component">
      <div class="vue-notification-group tm-notifications" style="width: 300px; top: 0px; right: 0px;"><span></span>
      </div>
    </div>
    <div class="container">
      <div class="form">
        <form id="write-us-form" class="form-inner" itemprop="potentialAction" itemscope=""
          itemtype="http://schema.org/CommunicateAction">
          <div class="form-title">
            <img src="./Временная электронная почта Gmail онлайн_files/papers.svg" alt="">
            <div itemprop="name">Напишите нам</div>
          </div>
          <div class="form-inputs">
            <input type="hidden" name="page" value="Partnership">
            <input type="hidden" name="type_id" value="2">
            <input type="hidden" name="_token" value="lyg7E4KjpfACW5E8my1GCyLIFWJFyHT6FA28AEKb">
            <div class="form-inputs-left">
              <div class="input-wrapper">
                <label for="name">Ваше имя</label>
                <input class="input" name="name" id="name" type="text" placeholder="Ваше имя">
              </div>

              <div class="input-wrapper">
                <label for="email">Your Email or Telegram</label>
                <input class="input" name="contact" id="email" type="text" placeholder="Ваше имя"
                  itemprop="recipient">
              </div>
            </div>
            <div class="form-inputs-right">
              <div class="input-wrapper">
                <label for="message">Сообщение</label>
                <textarea class="textarea" id="message" type="text" placeholder="Текст вашего сообщения" name="text"
                  itemprop="description"></textarea>
              </div>
            </div>
          </div>
          <div class="form-submit">
            <button class="button orange form-btn" type="submit" itemprop="potentialAction">
              <img src="./Временная электронная почта Gmail онлайн_files/send.svg" alt="">
              Отправить
            </button>
            <div class="form-privacy">
              Я согласен <a href="https://smsbower.net/ru/privacy">с политикой конфиденциальности и использования
                запрашиваемых данных</a>
            </div>
            <div id="captcha-form" data-sitekey="0x4AAAAAAAOPEtD_wZbQKuM_"></div>

          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="modal fade custom-modal-notification" id="reviewModalSuccess" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content custom-modal-notification">
        <img src="./Временная электронная почта Gmail онлайн_files/create-review.png"
          class="custom-modal-notification__image">
        <div class="custom-modal-notification__message">Спасибо за обращение!</div>
        <div class="custom-modal-notification__button">
          <button class="button orange" type="button" data-bs-toggle="modal" data-bs-target="#reviewModalSuccess">
            Хорошо
          </button>
        </div>
      </div>
    </div>
  </div>
  <script>
    const form = document.querySelector('#write-us-form');
    form.addEventListener('submit', (e) => {
      e.preventDefault();
      const formData = new FormData(form);

      try {
        fetch('/sendFeedback', {
            method: 'POST',
            body: formData
          })
          .then(response => response.json())
          .then(response => {
            if (response.status === 'ok') {
              let myModal = new bootstrap.Modal(document.querySelector('#reviewModalSuccess'));
              myModal.show();
              form.reset();
            } else {
              let txt = response.errors[Object.keys(response.errors)[0]][0];
              window.showNotificationVue(txt, 'error');
            }
          })
      } catch (e) {
        window.showNotificationVue('Error. Please try late', 'error');
      }
    })
  </script>
</div>
<script>
        document.addEventListener('DOMContentLoaded', () => {
            addEventClickCopyCms();
            scrollSpy();
        })

        const addEventClickCopyCms = () => {
            const elements = document.querySelectorAll('.copy-content .--button');
            elements.forEach((el) => {
                el.onclick = copyCodeFromCms;
            });
        }
        const copyCodeFromCms = (event) => {
            const parent = event.target.closest('.copy-content');
            const preHtml = parent.querySelector('pre') || parent;
            const content = preHtml.textContent;

            navigator.clipboard.writeText(content)
                .then(() => {
                    return true
                })
                .catch(err => {
                });
        }
        const scrollSpy = () => {
            document.querySelectorAll('#navbar-api > a').forEach(el => {
                el.addEventListener('click', e => {
                    e.preventDefault();
                    const targetId = e.target.getAttribute('href').substring(1);
                    const targetElement = document.getElementById(targetId);
                    let btn = targetElement.querySelector('.--icon.collapsed');
                    if (btn) {
                        btn.click();
                    }
                    const offset = document.querySelector('header').clientHeight - 10;

                    window.scrollTo({
                        top: targetElement.offsetTop - offset,
                        behavior: 'smooth'
                    });
                })
            })
        }
        window.addEventListener('scroll', () => {
            const offset = document.querySelector('header').clientHeight;
            let currentActiveLink = null;

            document.querySelectorAll('.faq-item').forEach((section) => {
                const sectionTop = section.offsetTop - offset;
                const sectionHeight = section.offsetHeight;
                const scrollPosition = document.documentElement.scrollTop || document.body.scrollTop;

                if (scrollPosition >= sectionTop && scrollPosition < sectionTop + sectionHeight) {
                    currentActiveLink = document.querySelector(`a[href="#${section.id}"]`);
                }
            });

            document.querySelectorAll('#navbar-api > a').forEach((link) => {
                link.classList.remove('active');
            });

            if (currentActiveLink) {
                currentActiveLink.classList.add('active');
            }
        });


    </script>
<?php get_footer(); ?>