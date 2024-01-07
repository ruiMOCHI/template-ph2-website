'use strict';

{
  const Header = document.getElementById('js-header');
  const HeaderButton = document.getElementById('js-headerButton');
  if (HeaderButton) {
    HeaderButton.addEventListener('click', () => {
      Header.classList.toggle('is-open')
    })
  }
}


{
  const allQuiz = document.querySelectorAll('.js-quiz');

  const setDisabled = (answers) => {
    answers.forEach(answer => {
      answer.disabled = true;
    });
  }

  const setTitle = (target, isCorrect) => {
    target.innerText = isCorrect ? '正解！' : '不正解...';
  }

  const setClassName = (target, isCorrect) => {
    target.classList.add(isCorrect ? 'is-correct' : 'is-incorrect');
  }

  allQuiz.forEach(quiz => {
    const answers = quiz.querySelectorAll('.js-answer');
    const answerBox = quiz.querySelector('.js-answerBox');
    const answerTitle = quiz.querySelector('.js-answerTitle');
    const answerText = quiz.querySelector('.js-answerText');

    answers.forEach(answer => {
      answer.addEventListener('click', () => {
        answer.classList.add('is-selected');
        setDisabled(answers);

        const isCorrect = Number(answer.getAttribute('data-correct')) === 1;

        answerText.innerText = quiz.querySelector('[data-correct="1"]').innerText;
        setTitle(answerTitle, isCorrect);
        setClassName(answerBox, isCorrect);
      });
    });
  });
} 