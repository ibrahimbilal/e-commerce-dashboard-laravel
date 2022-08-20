//- const watchdog = new CKSource.Watchdog();
//- window.watchdog = watchdog;
//- watchdog.setCreator( ( element, config ) => {
//- 	return CKSource.Editor
//- 		.create( element, config )
//- 		.then( editor => {
//- 			return editor;
//- 		} )
//- } );
//- watchdog.setDestructor( editor => {
//- 	return editor.destroy();
//- } );
//- watchdog.on( 'error', handleError );
//- watchdog
//- 	.create( document.querySelector( '.editor-container' ), {
//- 		heading: {
//- 			options: [
//- 				{ model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
//- 				{ model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
//- 				{ model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
//- 				{ model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
//- 				{ model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
//- 				{ model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' },
//- 				{ model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6' }
//- 			]
//- 		},
//- 		placeholder: 'Write The Product Description Here...',
//- 		toolbar: {
//- 			items: [
//- 				'heading', '|',
//- 				'alignment:left', 'alignment:right', 'alignment:center', 'alignment:justify', '|',
//- 				'bold', 'italic', 'underline', 'strikethrough', 'link', '|',
//- 				'fontBackgroundColor', 'fontColor', 'fontSize', '|',
//- 				'todoList', 'bulletedList', 'numberedList', '|',
//- 				'textPartLanguage', '|',
//- 				'outdent', 'indent', '|',
//- 				'blockQuote', 'insertTable', 'specialCharacters', '|',
//- 				'undo', 'redo', '|',
//- 				'removeFormat'
//- 			],
//- 			//- shouldNotGroupWhenFull: true,
//- 		},
//- 		fontSize: {
//- 			options: [
//- 				{ model: 'font12', view: {name: 'span', styles: {"font-size": '12px'}}, title: '12px', class: 'ck-fontsize-option' },
//- 				{ model: 'font14', view: {name: 'span', styles: {"font-size": '14px'}}, title: '14px', class: 'ck-fontsize-option' },
//- 				{ model: 'font16', view: {name: 'span', styles: {"font-size": '16px'}}, title: '16px', class: 'ck-fontsize-option' },
//- 				{ model: 'font18', view: {name: 'span', styles: {"font-size": '18px'}}, title: '18px', class: 'ck-fontsize-option' },
//- 				{ model: 'font20', view: {name: 'span', styles: {"font-size": '20px'}}, title: '20px', class: 'ck-fontsize-option' },
//- 				{ model: 'font22', view: {name: 'span', styles: {"font-size": '22px'}}, title: '22px', class: 'ck-fontsize-option' },
//- 				{ model: 'font26', view: {name: 'span', styles: {"font-size": '26px'}}, title: '26px', class: 'ck-fontsize-option' },
//- 				{ model: 'font30', view: {name: 'span', styles: {"font-size": '30px'}}, title: '30px', class: 'ck-fontsize-option' },
//- 				{ model: 'font36', view: {name: 'span', styles: {"font-size": '36px'}}, title: '36px', class: 'ck-fontsize-option' },
//- 			]
//- 		},
//- 		language: {
//- 			ui: 'en',
//- 			content: 'en',
//- 			textPartLanguage: [
//- 				{title: 'Arabic', languageCode: 'ar'},
//- 				{title: 'Kurdish', languageCode: 'ku'},
//- 				//- {title: 'English', languageCode: 'en'},
//- 				//- {title: 'French', languageCode: 'fr'},
//- 				//- {title: 'Spanish', languageCode: 'es'},
//- 			]
//- 		},
//- 		table: {
//- 			contentToolbar: [
//- 				'tableColumn',
//- 				'tableRow',
//- 				'mergeTableCells',
//- 				'tableCellProperties',
//- 				'tableProperties'
//- 			]
//- 		},

//- 	} )
//- 	.catch( handleError );

//- function handleError( error ) {
//- 	console.error( 'Oops, something went wrong!' );
//- 	console.error( 'Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:' );
//- 	console.warn( 'Build id: o3pwnv5dp0f4-69r08bnb5i4z' );
//- 	console.error( error );
//- }


// Function For Category Checklist
// function checkboxFunctions() {
//     const checkboxes = document.querySelectorAll(".cat-checkbox");

//     const checkboxActive = (el) => {
//         el.classList.add("cat-checkbox--active");
//         el.querySelector(".cat-checkbox__icon").innerHTML =
//             '<i class="fi-sr-checkbox"></i>';
//         el.querySelector(".cat-checkbox__input").setAttribute('checked', 'checked');

//         if (el.parentNode.querySelector("ul")) {
//             if (el.parentNode.querySelector("ul").querySelectorAll(".cat-checkbox").length > 0) {
//                 el.parentNode
//                     .querySelector("ul")
//                     .querySelectorAll(".cat-checkbox")
//                     .forEach((item) => {
//                         item.querySelector(".cat-checkbox__input").setAttribute('checked', 'checked');
//                         item.classList.add("cat-checkbox--active");
//                         item.querySelector(".cat-checkbox__icon").innerHTML =
//                             '<i class="fi-sr-checkbox"></i>';
//                     });
//             }
//         }

//         let parentListElement = el.parentNode.parentNode.previousElementSibling;
//         let siblingElements = el.parentNode.parentNode.querySelectorAll(".cat-checkbox");

//         if (parentListElement.classList.contains("cat-checkbox")) {
//             if (
//                 siblingElements.length ==
//                 el.parentNode.parentNode.querySelectorAll(".cat-checkbox--active").length
//             ) {
//                 parentListElement.classList.add("cat-checkbox--active");
//                 parentListElement.querySelector(".cat-checkbox__icon").innerHTML =
//                     '<i class="fi-sr-checkbox"></i>';
//             } else {
//                 checkboxPseudo(parentListElement);
//             }
//         }
//     };

//     const checkboxPseudo = (el) => {
//         if (el.classList.contains("cat-checkbox--active")) {
//             el.classList.remove("cat-checkbox--active");
//         }
//         el.querySelector(".cat-checkbox__icon").innerHTML =
//             '<i class="fi-rr-minus-small"></i>';
//     };

//     const checkboxInactive = (el) => {
//         el.querySelector(".cat-checkbox__input").removeAttribute('checked');
//         el.classList.remove("cat-checkbox--active");
//         el.querySelector(".cat-checkbox__icon").innerHTML =
//             '<i class="fi-rr-square"></i>';

//         if (el.parentNode.querySelectorAll(".cat-checkbox").length > 1) {
//             el.parentNode.querySelectorAll(".cat-checkbox").forEach((item) => {
//                 if (item.classList.contains("cat-checkbox--active")) {
//                     item.querySelector(".cat-checkbox__input").removeAttribute('checked');
//                     item.classList.remove("cat-checkbox--active");
//                     item.querySelector(".cat-checkbox__icon").innerHTML = '<i class="fi-rr-square"></i>';
//                 }
//             });
//         }

//         let parentListElement = el.parentNode.parentNode.previousElementSibling;
//         let siblingElements = el.parentNode.parentNode.querySelectorAll(".cat-checkbox");

//         if (parentListElement.classList.contains("cat-checkbox")) {
//             if (
//                 siblingElements.length >
//                 el.parentNode.parentNode.querySelectorAll(".cat-checkbox--active").length
//             ) {
//                 checkboxPseudo(parentListElement);
//             }
//         }
//     };

//     checkboxes.forEach((checkbox) => {
//         checkbox
//             .querySelector(".cat-checkbox__input")
//             .addEventListener("input", () => {
//                 let state = checkbox.classList.contains("cat-checkbox--active");
//                 if ( state ) {
//                     checkboxInactive(checkbox);
//                 } else {
//                     checkboxActive(checkbox);
//                 }
//             });
//     });
// }