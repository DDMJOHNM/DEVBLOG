---
title: 'Top 50 React'
description: 'React interview questions covering hooks, rendering, performance, and component patterns'
category: Interviewing
author: 'John Mason'
date: '2026-08-19 15:42'
---

Interview notes for React. Numbered questions with short answers and examples.

## 1. What is React and its benefits?

React is a JavaScript library by Facebook for building user interfaces, especially in single-page apps. Components are reusable and can hold their own state.

Key benefits:

- Component-based structure
- Efficient updates via the virtual DOM
- Declarative UI
- A large ecosystem and community

## 2. Difference Between React Node, Element, and Component

- A React Node is any renderable unit in React, like an element, string, number, or null.
- A React Element is an immutable object describing what to render, created with JSX or React.createElement.
- A React Component is a function or class that returns React Elements, allowing for reusable UI pieces.

## 3. What is JSX and how does it work?

JSX stands for JavaScript XML and is a syntax extension for JavaScript that lets you write HTML-like code within JavaScript.

It simplifies creating React components.
JSX is transformed into JavaScript function calls, usually by Babel.
For example, <div>Hello, world!</div> becomes React.createElement('div', null, 'Hello, world!').

## 4. Difference between state and props in React

In React, state is local data managed within a component that can change over time,
while props are read-only attributes passed from a parent to a child component.

- state is used for data that changes within a component,
- whereas props are used to pass data and event handlers to child components.

## 5. What is the purpose of the key prop in React?

The key prop in React uniquely identifies elements in a list,
helping React optimize rendering by efficiently updating and reordering items.

Without unique keys, React may unnecessarily re-render elements, leading to performance issues and bugs.

## 6. What is the consequence of using array indices as keys in React?

Using array indices as keys in React can cause performance issues and bugs.

When the order of items changes, React may fail to correctly identify which items have changed, leading to unnecessary re-renders or incorrect updates.

It's better to use unique identifiers for keys to ensure efficient DOM management.

## 7. What is the difference between Controlled and Uncontrolled React components?

In controlled components, form data is managed by the component's state, making it the single source of truth.
Changes to input values are handled via event handlers.

In uncontrolled components, the form state is internal and accessed through refs. Controlled components offer more control and are easier to test, while uncontrolled components are simpler to implement for basic cases.

Example of controlled component:

```jsx
function ControlledInput() {
  const [value, setValue] = React.useState('');
  return (
    <input
      type="text"
      value={value}
      onChange={(e) => setValue(e.target.value)}
    />
  );
}
```
Example of uncontrolled component:

```jsx
function UncontrolledInput() {
  const inputRef = React.useRef();
  return <input type="text" ref={inputRef} />;
}
```

## 8. What are some pitfalls of using context in React?

Context in React can lead to performance issues if not handled carefully,
causing unnecessary re-renders of components that consume the context,
even if only part of the context changes.

Overusing context for state management can also make the code harder to maintain and understand.
It's best to use context sparingly and consider other state management solutions like Redux or Zustand for more complex scenarios.

## 9. What are the benefits of using hooks in React?

Hooks allow you to use state and other React features in functional components, eliminating the need for classes.

They simplify code by reducing reliance on lifecycle methods, improve code readability, and make it easier to reuse stateful logic across components.
Common hooks like useState and useEffect help manage state and side effects.

## 10. What are the rules of React hooks?

React hooks must be called at the top level of a function, never inside loops, conditions, or nested functions.
They should only be called from React function components or custom hooks.
These rules help maintain correct state and lifecycle behavior.

## 11. What is the difference between useEffect and useLayoutEffect in React?

useEffect and useLayoutEffect are both used for handling side effects in React functional components but differ in timing:

- useEffect runs asynchronously after the DOM has painted, ideal for tasks like data fetching or subscriptions.
- useLayoutEffect runs synchronously after DOM mutations but before the browser paints, useful for tasks like measuring DOM elements or synchronizing the UI with the DOM.

## 12. What does the dependency array of useEffect affect?

The dependency array of useEffect controls when the effect re-runs:

- If it's empty, the effect runs only once after the initial render.
- If it contains variables, the effect re-runs whenever any of those variables change.
- If omitted, the effect runs after every render.

## 13. What is the useRef hook in React and when should it be used?

The useRef hook creates a mutable object that persists through renders, allowing direct access to DOM elements,
storing mutable values without causing re-renders,
and maintaining references to values.
For instance, useRef can be utilized to focus on an input element:

```jsx
import React, { useRef, useEffect } from 'react';

function TextInputWithFocusButton() {
  const inputEl = useRef(null);
  useEffect(() => {
    inputEl.current.focus();
  }, []);
  return <input ref={inputEl} type="text" />;
}
```

## 14. What is the purpose of callback function argument format of setState() in React and when should it be used?

The callback function format of setState() in React ensures that state updates are based on the most current state and props.
This is essential when the new state depends on the previous state.
Instead of passing an object directly to setState(), you provide a function that takes the previous state and props as arguments, returning the updated state.

```jsx
this.setState((prevState, props) => ({
  counter: prevState.counter + props.increment,
}));
```

## 15. What is the useCallback hook in React and when should it be used?

The useCallback hook memoizes functions to prevent their recreation on every render.
This is especially beneficial when passing callbacks to optimized child components that depend on reference equality to avoid unnecessary renders.
Use it when a function is passed as a prop to a child component.

```jsx
const memoizedCallback = useCallback(() => {
  doSomething(a, b);
}, [a, b]);
```

## 16. What is the useMemo hook in React and when should it be used?

The useMemo hook memoizes costly calculations, recomputing them only when dependencies change.
This enhances performance by avoiding unnecessary recalculations.
It should be used for computationally intensive functions that don't need to run on every render.

```jsx
const memoizedValue = useMemo(() => computeExpensiveValue(a, b), [a, b]);
```

## 17. What is the useReducer hook in React and when should it be used?

The useReducer hook manages complex state logic in functional components, serving as an alternative to useState.
It's ideal when state has multiple sub-values or when the next state relies on the previous one. It accepts a reducer function and an initial state.

```jsx
const [state, dispatch] = useReducer(reducer, initialState);
```

## 18. What is the useId hook in React and when should it be used?

The useId hook generates unique IDs for elements within a component, which is crucial for accessibility by linking form inputs with labels.
It guarantees unique IDs across the application even if the component renders multiple times.

```jsx
import { useId } from 'react';

function MyComponent() {
  const id = useId();
  return (
    <div>
      <label htmlFor={id}>Name:</label>
      <input id={id} type="text" />
    </div>
  );
}
```

## 19. What does re-rendering mean in React?

Re-rendering refers to updating a component's output in the DOM due to changes in state or props.

When these changes occur, React triggers a re-render to ensure the UI reflects current data by calling the render method again.

## 20. What are React Fragments used for?

React Fragments group multiple elements without adding extra nodes to the DOM.
This allows returning multiple elements from a component's render method without wrapping them in an additional HTML element.
You can utilize shorthand syntax <>...</> or React.Fragment.

```jsx
return (
  <>
    <ChildComponent1 />
    <ChildComponent2 />
  </>
);
```

## 21. What is forwardRef() in React used for?

forwardRef() allows passing a ref through a component to one of its children. This is useful for accessing a DOM element or child component's instance directly from a parent.

```jsx
import React, { forwardRef } from 'react';

const MyComponent = forwardRef((props, ref) => <input ref={ref} {...props} />);
```

Refs provide a way to access DOM nodes or React elements created in the render method.

In the typical React dataflow, props are the only way that parent components interact with their children. To modify a child, you re-render it with new props. However, there are a few cases where you need to imperatively modify a child outside of the typical dataflow. The child to be modified could be an instance of a React component, or it could be a DOM element. For both of these cases, React provides an escape hatch.

When to Use Refs
There are a few good use cases for refs:

Managing focus, text selection, or media playback.
Triggering imperative animations.
Integrating with third-party DOM libraries.
Avoid using refs for anything that can be done declaratively.

For example, instead of exposing open() and close() methods on a Dialog component, pass an isOpen prop to it.

## 22. How do you reset a component's state in React?

To reset state in React, set it back to its initial value using the setState function. For example:

```jsx
const [state, setState] = useState(initialState);
setState(initialState);
```

## 23. Why does React recommend against mutating state?

React advises against mutating state as it can lead to unexpected behaviors and bugs.

State immutability helps efficiently determine when components need re-rendering; direct mutations may prevent React from detecting changes.

## 24. What are error boundaries in React for?

Error boundaries catch JavaScript errors in their child components, log them, and display fallback UI instead of crashing the application.

They utilize componentDidCatch and static getDerivedStateFromError methods but do not catch errors in event handlers or asynchronous code.

## 25. How do you test React applications?

Testing React applications can be done using Jest and React Testing Library.

Jest serves as the testing framework while React Testing Library provides utilities for testing components similarly to user interactions.

## 26. Explain what React hydration is

Hydration involves attaching event listeners and making server-rendered HTML interactive on the client side.

After server-side rendering, React initializes dynamic behavior by attaching event handlers.

## 27. What are React Portals used for?

React Portals allow rendering children into a DOM node outside the parent component's hierarchy.

This is useful for modals or tooltips that need to escape parent overflow or z-index constraints.

## 28. How do you debug React applications?

Debugging can be done using the React Developer Tools extension for inspecting component hierarchies and states along with console.log statements for logging data and errors.

## 29. What is React strict mode and what are its benefits?

React strict mode helps identify potential issues by activating additional checks and warnings without affecting production builds.

Benefits include highlighting unsafe lifecycle methods and detecting unexpected side effects.

## 30. How do you localize React applications?

Localization typically involves libraries like react-i18next or react-intl. Set up translation files for different languages and configure the library within your app using provided hooks or components.

```jsx
// Example using react-i18next
import { useTranslation } from 'react-i18next';

const MyComponent = () => {
  const { t } = useTranslation();
  return <p>{t('welcome_message')}</p>;
};
```

## 31. What is code splitting in a React application?

Code splitting enhances performance by dividing code into smaller chunks loaded on demand, thereby reducing initial load times. This can be achieved through dynamic import() statements or using React's React.lazy and Suspense.

```jsx
// Using React.lazy and Suspense
const LazyComponent = React.lazy(() => import('./LazyComponent'));

function App() {
  return (
    <React.Suspense fallback={<div>Loading...</div>}>
      <LazyComponent />
    </React.Suspense>
  );
}
```

## 32. How would one optimize the performance of React contexts to reduce rerenders?

Optimizing context performance involves memoizing context values with useMemo, splitting contexts for isolated state changes, and employing selectors to rerender only necessary components.

const value = useMemo(() => ({ state, dispatch }), [state, dispatch]);

Memoizing context values
One of the most effective ways to reduce unnecessary rerenders is to memoize the context value. By using useMemo, you can ensure that the context value only changes when its dependencies change.

import React, { createContext, useMemo, useState } from 'react';

const MyContext = createContext();

const MyProvider = ({ children }) => {
  const [state, setState] = useState(initialState);

  const value = useMemo(() => ({ state, setState }), [state]);

  return <MyContext.Provider value={value}>{children}</MyContext.Provider>;
};

## 33. What are higher-order components in React?

Higher-order components (HOCs) are functions that take a component and return a new one with added props or behavior, facilitating logic reuse across components.

```jsx
const withExtraProps = (WrappedComponent) => {
  return (props) => <WrappedComponent {...props} extraProp="value" />;
};

const EnhancedComponent = withExtraProps(MyComponent);
```

## 34. What is the Flux pattern?

The Flux pattern manages application state through unidirectional data flow, simplifying debugging and enhancing maintainability with clear separation of concerns between Dispatcher, Stores, Actions, and Views.

## 35. Explain one-way data flow of React

One-way data flow means data moves from parent to child components only, making it predictable and easier to debug while enhancing maintainability and performance.

## 36. How do you handle asynchronous data loading in React applications?

Asynchronous data loading uses useEffect alongside useState hooks; fetching data inside useEffect updates state with fetched results ensuring re-renders occur with new data.

```jsx
import React, { useState, useEffect } from 'react';

const FetchAndDisplayData = () => {
  const [info, updateInfo] = useState(null);
  const [isLoading, toggleLoading] = useState(true);

  useEffect(() => {
    const retrieveData = async () => {
      try {
        const res = await fetch('https://api.example.com/data');
        const data = await res.json();
        updateInfo(data);
      } catch (err) {
        console.error('Error fetching data:', err);
      } finally {
        toggleLoading(false);
      }
    };

    retrieveData();
  }, []);

  return (
    <div>
      {isLoading ? (
        <p>Fetching data, please wait...</p>
      ) : (
        <pre>{JSON.stringify(info, null, 2)}</pre>
      )}
    </div>
  );
};

export default FetchAndDisplayData;
```

## 37. Explain server-side rendering of React applications and its benefits

Server-side rendering (SSR) involves rendering components on the server before sending fully rendered HTML to clients,
improving initial load times and SEO through efficient hydration processes.

## 38. Explain static generation of React applications

Static generation pre-renders HTML at build time instead of runtime;
this approach enhances performance by delivering static content quickly while improving SEO outcomes.

## 39. Explain the presentational vs container component pattern in React

In React, the presentational vs container component pattern distinguishes between components that focus on appearance (presentational components) and those that manage logic and state (container components).

Presentational components render HTML and CSS, while container components handle data and behavior. This separation leads to a cleaner and more organized codebase.

## 40. What are some common pitfalls when doing data fetching in React?

Common pitfalls in data fetching with React include failing to handle loading and error states, neglecting to clean up subscriptions which can cause memory leaks, and improperly using lifecycle methods or hooks.
Always ensure proper handling of these states, clean up after components, and utilize useEffect for side effects in functional components.

## 41. What are render props in React?

Render props in React allow code sharing between components through a prop that is a function. This function returns a React element, enabling data to be passed to child components. This technique facilitates logic reuse without relying on higher-order components or hooks.

```jsx
class DataFetcher extends React.Component {
  state = { data: null };

  componentDidMount() {
    fetch(this.props.url)
      .then((response) => response.json())
      .then((data) => this.setState({ data }));
  }

  render() {
    return this.props.render(this.state.data);
  }
}

// Usage
<DataFetcher
  url="/api/data"
  render={(data) => <div>{data ? data.name : 'Loading...'}</div>}
/>;
```

## 42. What are some React anti-patterns?

React anti-patterns are practices that can lead to inefficient or hard-to-maintain code.

Common examples include:

- Directly mutating state instead of using setState
- Using componentWillMount for data fetching
- Overusing componentWillReceiveProps
- Not using keys in lists
- Excessive inline functions in render
- Deeply nested state

## 43. How do you decide between using React state, context, and external state managers?

Choosing between React state, context, and external state managers depends on your application's complexity.
Use React state for local component state, context for global state shared across multiple components, and external managers like Redux or MobX for complex state management requiring advanced features.

## 44. Explain the composition pattern in React

The composition pattern in React involves building components by combining smaller, reusable ones instead of using inheritance.

This encourages creating complex UIs by passing components as children or props.

```jsx
function WelcomeDialog() {
  return (
    <Dialog>
      <h1>Welcome</h1>
      <p>Thank you for visiting our spacecraft!</p>
    </Dialog>
  );
}

function Dialog(props) {
  return <div className="dialog">{props.children}</div>;
}
```

## 45. What is virtual DOM in React?

The virtual DOM is a lightweight representation of the actual DOM used by React.
It enables efficient UI updates by comparing the virtual DOM with the real DOM and applying only necessary changes through a process called reconciliation.##

## 46. How does virtual DOM in React work? What are its benefits and downsides?

The virtual DOM works by creating a new tree whenever a component's state changes and comparing it with the previous tree through "reconciliation."
This allows only the differences to be updated in the actual DOM, enhancing performance.
Benefits include improved efficiency and a declarative UI management style, while downsides may include added complexity for simple applications.

## 47. What is React Fiber and how is it an improvement over the previous approach?

React Fiber is a complete rewrite of React's reconciliation algorithm introduced in version 16.
It enhances rendering by breaking tasks into smaller units, allowing React to pause and resume work, which improves UI responsiveness.
This enables features like time slicing and suspense that weren't possible before.

## 48. What is reconciliation in React?

Reconciliation is the process where React updates the DOM to match changes in the virtual DOM. When a component's state or props change,
a new virtual DOM tree is created and compared with the previous one through "diffing," allowing efficient updates to only changed parts of the actual DOM.

## 49. What is React Suspense?

React Suspense allows handling asynchronous operations more elegantly within components.
It provides fallback content while waiting for resources like data or code to load. You can use it alongside React.lazy for code splitting.

```jsx
const LazyComponent = React.lazy(() => import('./LazyComponent'));

function MyComponent() {
  return (
    <React.Suspense fallback={<div>Loading...</div>}>
      <LazyComponent />
    </React.Suspense>
  );
}
```

## 50. Explain what happens when setState is called in React

When setState is invoked, it schedules an update to the component's state object.
React merges the new state with the current one and triggers a re-render of the component.
This process is asynchronous; thus, changes may not occur immediately,
and multiple setState calls can be batched for performance optimization.

## References

- <https://www.greatfrontend.com/blog/50-essential-reactjs-interviews-questions>
- <https://api.example.com/data'>
